<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Mixer;
use App\Venue;
use App\MenuItem;
use Illuminate\Support\Str;
use App\MenuCategory;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Validator;   

class MenuItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('menu-item.index');
    }

    public function menuItem()
    {
        return view('menu-item.items');
    }

    public function menuMixer(){
        return view('menu-item.mixer');
    }

    public function getMenuCategoryItems(Request $request){
        //For Venue Specific
        $user = Auth::user();
        if($user->user_type != 0){
            $menuItems = MenuCategory::where('venue_id',$user->venues->first()->id)->get();
            return $menuItems;
        }
    }

    public function saveMenuCategoryItem(Request $request){
        $request->validate([
           'name' => 'required',
           'description' => 'required'
        ]);

        $input = $request->all();
        $user = Auth::user();

        if(!empty($input['id'])){
            $category = MenuCategory::where('id', $input['id'])->first();
        }else{
            $category = new MenuCategory;
        }

        $category->name = $input['name'];
        $category->venue_id = $user->venues->first()->id;
        $category->description = $input['description'];
        $category->save();
    }

    public function getMenuItems(Request $request){
        //For Venue Specific
        $user = Auth::user();
        if($user->user_type != 0){
            $menuItems = MenuItem::where(['venue_id' => $user->venues->first()->id, 'is_active' => 1])->get();
            return $menuItems;
        }
    }

    public function saveMenuItem(Request $request){
        $input = $request->all();
        $user = Auth::user();
        
        if(!empty($input['id'])){
            $menuItem = MenuItem::where('id', $input['id'])->first();
        }else{
            $menuItem = new MenuItem;
        }
        $menuItem->name = $input['name'];
        $menuItem->description = $input['description'];
        $menuItem->access_roles = json_encode($input['access_roles']);
        $menuItem->menu_categories = json_encode($input['categories']);
        $menuItem->mixers = json_encode($input['mixers']);
        $menuItem->sling_price = $input['sling_price'];
        $menuItem->vendor_price = $input['vendor_price'];
        $menuItem->stock_quantity = $input['quantity'];
        $menuItem->venue_id = $user->venues->first()->id;
        $menuItem->tax_code = '';
        $menuItem->minimum_purchase_quantity = $input['min_quantity'];
        $menuItem->is_unlimited = $input['is_unlimited'];
        $menuItem->is_active = 1;
        $menuItem->measure = $input['measure'];
        $menuItem->unit_of_measure = $input['uom'];
        $word = "images";
     
        $contains = Str::contains($input['img_url'], 'images');
        if($contains == false){
 
            $img = \Image::make($input['img_url']);

            $mime = $img->mime();  //edited due to updated to 2.x
            if ($mime == 'image/jpeg')
                $extension = '.jpg';
            elseif ($mime == 'image/png')
                $extension = '.png';
            elseif ($mime == 'image/gif')
                $extension = '.gif';
            else
                $extension = '';
            $name = sha1(date('YmdHis') . $this->generateRandomString());
            $img_name = $name . $extension;

            $path = public_path('/images/menu/items/' . $img_name);
            $img->save($path);
            $menuItem->image_url = ($input['img_url']) ? '/images/menu/items/' . $img_name : '';
        }

        $menuItem->save();
    }

    public function mixerUpload(Request $request){
        $user = Auth::user();
    }

    public function deleteMenuItem(Request $request){
        $input = $request->all();
        $menuItem = MenuItem::where('id', $input['id'])->update(['is_active' => 0]);
        return $menuItem;
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function getMenuMixer(){
        //for Venue specific
        $user = Auth::user();
        if($user->user_type != 0){
            $menuItems = Mixer::where('venue_id',$user->venues->first()->id)->get();
            return $menuItems;
        }
    }

    public function saveMixerDetails(Request $request){
        $user = Auth::user();
        $input = $request->all();
        //dd($input);
        if(!empty($input['img_url'])){
            $img = \Image::make($input['img_url']);
            $mime = $img->mime();  //edited due to updated to 2.x
            if ($mime == 'image/jpeg')
                $extension = '.jpg';
            elseif ($mime == 'image/png')
                $extension = '.png';
            elseif ($mime == 'image/gif')
                $extension = '.gif';
            else
                $extension = '';
            $name = sha1(date('YmdHis') . $this->generateRandomString());
            $img_name = $name . $extension;

            $path = public_path('images/menu/mixer/' . $img_name);
            $img->save($path);
        }
        $mixer = new Mixer;
        $mixer->venue_id = $user->venues->first()->id;
        $mixer->img_url = ($input['img_url']) ? $path : '';
        $mixer->name = $input['name'];
        $mixer->stock_quantity = intval($input['quantity']);
        $mixer->is_unlimited = $input['is_unlimited'];
        $mixer->sling_price = $input['sling_price'];
        $mixer->save();

        return $mixer;
    }
}
