<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShortLink;
use Illuminate\Support\Facades\Validator;

class ShortLinkController extends Controller
{

    public function test(){
        return "1";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shortLinks = ShortLink::latest()->paginate(8);
        if ($request->ajax()) {
            return view('data.shortenLink', compact('shortLinks'));
        }
        else{
            return view('shortenLink', compact('shortLinks'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),$this->rules());
        if($validator->fails()){
            if($request->ajax()){
                return response()->json(['errors' => $validator->errors()]);
            }
            else{
                return redirect()->back()->withInput()->withErrors($validator);
            }
        }

        if($request->code){

            $find = ShortLink::where("code",$request->code)->first();
            if($find == null){
                if($request->ajax()){
                    return response()->json(['error' => 'No Found!']);
                }
                else{
                    return redirect()->route('index');
                }
            }

            $find->name = $request->name;
            $find->link = $request->link;
            $find->save();
        }
        else{
            $input['name'] = $request->name;
            $input['link'] = $request->link;
            $input['code'] = parent::RandomOrderId(12);

            ShortLink::create($input);
        }

        if($request->ajax()){
            return response()->json(['success' => 'Shorten Link Generated Successfully!']);
        }
        else{
            return redirect()
                ->route('index')
                ->with('success', 'Shorten Link Generated Successfully!');
        }
    }

    public function rules(){
        return [
            'link' => 'required|url',
            'name' => 'required|min:1|max:191',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shortenLink($code)
    {
        $find = ShortLink::where('code', $code)->first();

        if($find == null){
            return redirect()->route('index');
        }

        return redirect($find->link);
    }

    public function delete(Request $request)
    {
        $code = $request->code;
        $find = ShortLink::where('code', $code)->first();
        if($find == null){
            if($request->ajax()){
                return response()->json(['error' => 'No Found!']);
            }
            else{
                return redirect()->route('index');
            }
        }

        $find->delete();

        if($request->ajax()){
            return response()->json(['success' => 'Shorten Link Deleted Successfully!']);
        }
        else{
            return redirect()
                ->route('index')
                ->with('success', 'Shorten Link Deleted Successfully!');
        }
    }

    public function show(Request $request)
    {
        $code = $request->code;
        $find = ShortLink::where('code', $code)->first();
        if($find == null){
            if($request->ajax()){
                return response()->json(['error' => 'No Found!']);
            }
            else{
                return redirect()->route('index');
            }
        }

        if($request->ajax()){
            return response()->json(['success' =>$find]);
        }
        else{
            return redirect()
                ->route('index');
        }
    }

}
