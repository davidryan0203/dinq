<?php

namespace App\Http\Controllers;

use Auth;
use App\Supplier;
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

    public function adminMenuItems()
    {
        return view('admin.admin-menu');
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
            $menuItems = MenuCategory::with('venue.user')->where('venue_id',$user->venues->first()->id)->get();
            return $menuItems;
        }

        if($user->user_type == 0){
            $menuItems = MenuCategory::with('venue.user')->get();
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
        if(Auth::user()->user_type == 0){
            $category->venue_id = $input['venue']['venue']['id'];
        }else{
            $category->venue_id = $user->venues->first()->id;
        }
        $category->description = $input['description'];
        $category->save();
    }

    public function getAdminMenuItems($id){
        $results = [];
        $mixerStocks = [];
        $menuItems = MenuItem::with('taxRate')->where('stock_quantity', '!=', 0)->where(['venue_id' => $id, 'is_active' => 1])->where('supplier_id', '=', 0)->get();
        foreach ($menuItems as $key => $item) {
            $item['orderQuantity'] = 0;
            if($item['mixers']){
                //dd($item['mixers']);
                $mixers = collect($item['mixers'])->toArray();
                //dd($mixers);
                foreach($mixers as $key => $mixer) {
                    //dd($mixer->id);
                    $mixerData[] = Mixer::where('stock_quantity' , '!=',0)->where(['id' => $mixer->id, 'is_active' => 1])->first();
                }
               $mixerStocks = collect($mixerData)->unique()->filter()->toArray();
            }
            $item['sling_item_price'] = $item['sling_price'];
            $item['mixerStocks'] = ($mixerStocks);
            // unset($item['mixers']);
            $results[] = $item;
        }
        return $results;
    }

    public function getAdminMenuCategory($id){
        //For Venue Specific
        $menuItems = MenuCategory::with('venue.user')->where('venue_id',$id)->get();
        return $menuItems;
    }

    public function getAdminMenuMixers($id){
        //for Venue specific
        $menuItems = Mixer::where('venue_id',$id)->get();
        return $menuItems;
    }

    public function filterMenuItems(Request $request){
        $user = Auth::user();
        $results = [];
        $mixerStocks = [];
        $input = $request->all();
        if(Auth::user()->user_type == 2){
            if(($input['venue']) == 0){
                $menuItems = MenuItem::with('venue.user','taxRate')->where('supplier_id','=',Auth::user()->supplier->user_id)->where('supplier_id' , '!=', 0)->where('stock_quantity', '!=', 0)->where(['is_active' => 1])->get();
            }else{            
                $menuItems = MenuItem::with('venue.user','taxRate')->where('supplier_id','=',Auth::user()->supplier->user_id)->where('stock_quantity', '!=', 0)->where(['venue_id' => $input['venue']['id'],'is_active' => 1])->where('supplier_id' , '!=', 0)->get();                
            }
        }else{
            if(isset($input['venue']['venue'])){            
                $menuItems = MenuItem::with('venue.user','taxRate')->where('stock_quantity', '!=', 0)->where(['venue_id' => $input['venue']['venue']['id'],'is_active' => 1])->get();
            }else{
                $menuItems = MenuItem::with('venue.user','taxRate')->where('stock_quantity', '!=', 0)->where(['is_active' => 1])->get();
            }
        }
        
        foreach ($menuItems as $key => $item) {
            if(Auth::user()->user_type == 2 && in_array('supplier',$item['access_roles'])){
                $item['orderQuantity'] = 0;
                if(collect($item['mixers'])->isNotEmpty()){
                    //dd($item['mixers']);
                    $mixers = collect($item['mixers'])->toArray();
                }
                $item['sling_item_price'] = $item['sling_price'];
                $item['mixerStocks'] = $item['mixers'];
                // unset($item['mixers']);
                $results[] = $item;
            }

            if(Auth::user()->user_type == 1 && in_array('venue',$item['access_roles'])){
                $item['orderQuantity'] = 0;
                if(collect($item['mixers'])->isNotEmpty()){
                    //dd($item['mixers']);
                    $mixers = collect($item['mixers'])->toArray();
                }
                $item['sling_item_price'] = $item['sling_price'];
                $item['mixerStocks'] = $item['mixers'];
                // unset($item['mixers']);
                $results[] = $item;
            }

            if(Auth::user()->user_type == 0 && in_array('admin',$item['access_roles'])){
                $item['orderQuantity'] = 0;
                if(collect($item['mixers'])->isNotEmpty()){
                    //dd($item['mixers']);
                    $mixers = collect($item['mixers'])->toArray();
                }
                $item['sling_item_price'] = $item['sling_price'];
                $item['mixerStocks'] = $item['mixers'];
                // unset($item['mixers']);
                $results[] = $item;
            }
        }
        return $results;
    }

    public function getMenuItems(Request $request){
        //For Venue Specific
        $user = Auth::user();
        $results = [];
        $mixerStocks = [];
        if($user->user_type == 0){
            $menuItems = MenuItem::with('venue.user','venue.currency','taxRate')->where('stock_quantity', '!=', 0)->where(['is_active' => 1])->get();
            foreach ($menuItems as $key => $item) {
                $item['orderQuantity'] = 0;
                if(in_array('admin',$item['access_roles'])){
                    if(collect($item['mixers'])->isNotEmpty()){
                        //dd($item['mixers']);
                        $mixers = collect($item['mixers'])->toArray();
                        //dd($mixers);
                       //  foreach($mixers as $key => $mixer) {
                       //      //dd($mixer->id);
                       //      $mixerData[] = Mixer::where('stock_quantity' , '!=',0)->where(['id' => $mixer->id, 'is_active' => 1])->first();
                       //  }
                       // $mixerStocks = collect($mixerData)->unique()->filter()->toArray();
                    }
                    $item['sling_item_price'] = $item['sling_price'];
                    $item['mixerStocks'] = $item['mixers'];
                    // unset($item['mixers']);
                    if($item['venue']['user']['is_active'] == 1){
                        $results[] = $item;
                    }
                }
            }
            return $results;
        }

        if($user->user_type == 1){
            $menuItems = MenuItem::with('venue.user','venue.currency','taxRate')->where('stock_quantity', '!=', 0)->where(['venue_id' => $user->venues->first()->id, 'is_active' => 1])->get();
            foreach ($menuItems as $key => $item) {
                if(in_array('venue',$item['access_roles']) || in_array('public',$item['access_roles'])){
                    $item['orderQuantity'] = 0;
                    if($item['mixers']){
                        //dd($item['mixers']);
                        $mixers = collect($item['mixers'])->toArray();
                        //dd($mixers);
                        foreach($mixers as $key => $mixer) {
                            //dd($mixer->id);
                            $mixerData[] = Mixer::where('stock_quantity' , '!=',0)->where(['id' => $mixer->id, 'is_active' => 1])->first();
                        }
                       $mixerStocks = collect($mixerData)->unique()->filter()->toArray();
                    }
                    $item['sling_item_price'] = $item['sling_price'];
                    $item['mixerStocks'] = $item['mixers'];
                    // unset($item['mixers']);
                    $results[] = $item;
                }
            }
            return $results;
        }

        if($user->user_type == 2){
            $supplier = Supplier::where('user_id', '=', Auth::user()->id)->first();
            //dd($supplier['id']);
            $menuItems = MenuItem::with('venue.user','venue.currency','taxRate')->where('stock_quantity', '!=', 0)->where('supplier_id', '=', Auth::user()->id)->get();
            foreach ($menuItems as $key => $item) {
                if(in_array('supplier',$item['access_roles'])){
                    $item['orderQuantity'] = 0;
                    if($item['mixers']){
                        //dd($item['mixers']);
                        $mixers = collect($item['mixers'])->toArray();
                        //dd($mixers);
                        foreach($mixers as $key => $mixer) {
                            //dd($mixer->id);
                            $mixerData[] = Mixer::where('stock_quantity' , '!=',0)->where(['id' => $mixer->id, 'is_active' => 1])->first();
                        }
                       $mixerStocks = collect($mixerData)->unique()->filter()->toArray();
                    }
                    $item['sling_item_price'] = $item['sling_price'];
                    $item['mixerStocks'] = $item['mixers'];
                    // unset($item['mixers']);
                    $results[] = $item;
                }
            }
            //dd(collect($results)->toArray());
            return $results;
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
        if($input['supplierId'] != 0){
            $menuItem->supplier_id = $input['supplierId']['id'];
        }
        $menuItem->name = $input['name'];
        $menuItem->description = $input['description'];
        $menuItem->access_roles = json_encode($input['access_roles']);
        $menuItem->menu_categories = json_encode($input['categories']);
        $menuItem->mixers = json_encode($input['mixers']);
        $menuItem->sling_price = $input['sling_price'];
        $menuItem->vendor_price = $input['vendor_price'];
        $menuItem->stock_quantity = $input['quantity'];
        if(Auth::user()->user_type != 0){
            $menuItem->venue_id = $user->venues->first()->id;
        }else{
            $menuItem->venue_id = $input['venue']['venue']['id'];
        }
        $menuItem->tax_rate_id = $input['tax_type'];
        $menuItem->minimum_purchase_quantity = $input['min_quantity'];
        $menuItem->is_unlimited = $input['is_unlimited'];
        $menuItem->is_active = 1;
        $menuItem->measure = $input['measure'];
        $menuItem->unit_of_measure = $input['uom'];
        $word = "images";
        
        $contains = Str::contains($input['img_url'], 'images');
        if(isset($input['img_url'])){
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
        }

        $menuItem->save();
        return 'success';
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
        if(Auth::user()->user_type == 0){
            $menuItems = Mixer::with('venue.user')->get();
            return $menuItems;
        }

        if(Auth::user()->user_type == 1){
            $menuItems = Mixer::with('venue.user')->where('venue_id',$user->venues->first()->id)->get();
            return $menuItems;
        }

        if(Auth::user()->user_type == 2){
            $menuItems = Mixer::where('supplier_id',$user->supplier->first()->id)->get();
            return $menuItems;
        }
    }

    public function saveMixerDetails(Request $request){
        $user = Auth::user();
        $input = $request->all();
        if(isset($input['img_url'])){
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

            $path = public_path('/images/menu/mixer/' . $img_name);
            $img->save($path);
        }
        $mixer = new Mixer;
        
        $mixer->img_url = ($input['img_url']) ? '/images/menu/mixer/' . $img_name : '';
        $mixer->name = $input['name'];
        $mixer->stock_quantity = intval($input['quantity']);
        $mixer->is_unlimited = $input['is_unlimited'];
        $mixer->category_id = $input['categories']['id'];
        $mixer->description = $input['description'];
        if(Auth::user()->user_type == 0){
            $mixer->venue_id = $input['venue']['venue']['id'];
        }else{
            $mixer->venue_id = $user->venues->first()->id;
        }
        $mixer->venue_price = $input['vendor_price'];
        $mixer->sling_price = $input['sling_price'];
        $mixer->save();

        return $mixer;
    }
}
