<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Comment;

class CommentController extends Controller
{
    public function index(Request $request) 
    {

        $product = Product::findOrfail($request->input('id'));
        $comments = $product->comments;
        

            $result = [
                'product' => $product,
                'comments' => $comments
            ];

            if ($request->ajax()) {
                return $result;
            }
            
            return view(
            'product_details', $result
        );
    }

    public function insertComments(Request $request) 
    {
        $comment = new Comment();
        $comment->fill([
            'product_id' => $request->input('id'),
            'message' => $request->input('comment'),
        ]);
        $comment->save();

        // return redirect("/product_details?id=$request->id");
        return redirect()->route('productDetails', ['id' => $request->id]);
    }

    public function comments(Request $request)
    {
        $comments = Product::join('comments', 'product_id', '=', 'products.id')
                           ->select('products.*', 'comments.id AS cid', 'comments.message', 'comments.created_at')
                           ->get();

        if ($request->ajax()) {
            return $comments;
        }
        
        return view('comments', 
        [
            'comments' => $comments
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        
        return redirect()->route('comments.index');
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        return view('comments_edit', ['comment' => $comment]);
    }

    public function update($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update($this->validateRequest());

        return redirect()->route('comments.index');
    }

    public function validateRequest()
    {
        return request()->validate([
            'message' => 'required|min:3',
        ]);
    }
}