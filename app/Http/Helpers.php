<?php

use App\Models\Message;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Like;
use App\Models\Shipping;
use App\Models\Cart;
use App\Models\Settings;
use Illuminate\Support\Facades\Http;
use App\Models\UserLocation;
// use Auth;
class Helper
{
    public static function messageList()
    {
        return Message::whereNull('read_at')->orderBy('created_at', 'desc')->get();
    }
    public static function getAllCategory()
    {
        $category = new Category();
        $menu = $category->getAllParentWithChild();
        return $menu;
    }

    public static function getHeaderCategory()
    {
        $category = new Category();
        // dd($category);
        $menu = $category->getAllParentWithChild();

        if ($menu) {
?>

            <li>
                <a href="javascript:void(0);">Category<i class="ti-angle-down"></i></a>
                <ul class="dropdown border-0 shadow">
                    <?php
                    foreach ($menu as $cat_info) {
                        if ($cat_info->child_cat->count() > 0) {
                    ?>
                            <li><a href="<?php echo route('product-cat', $cat_info->slug); ?>"><?php echo $cat_info->title; ?></a>
                                <ul class="dropdown sub-dropdown border-0 shadow">
                                    <?php
                                    foreach ($cat_info->child_cat as $sub_menu) {
                                    ?>
                                        <li><a href="<?php echo route('product-sub-cat', [$cat_info->slug, $sub_menu->slug]); ?>"><?php echo $sub_menu->title; ?></a></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li><a href="<?php echo route('product-cat', $cat_info->slug); ?>"><?php echo $cat_info->title; ?></a></li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </li>
<?php
        }
    }

    public static function productCategoryList($option = 'all')
    {
        if ($option = 'all') {
            return Category::orderBy('id', 'DESC')->get();
        }
        return Category::has('products')->orderBy('id', 'DESC')->get();
    }

    public static function postTagList($option = 'all')
    {
        if ($option = 'all') {
            return PostTag::orderBy('id', 'desc')->get();
        }
        return PostTag::has('posts')->orderBy('id', 'desc')->get();
    }

    public static function postCategoryList($option = "all")
    {
        if ($option = 'all') {
            return PostCategory::orderBy('id', 'DESC')->get();
        }
        return PostCategory::has('posts')->orderBy('id', 'DESC')->get();
    }
    // Cart Count
    public static function cartCount($user_id = '')
    {

        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Cart::where('user_id', $user_id)->where('order_id', null)->sum('quantity');
        } else {
            return 0;
        }
    }
    // relationship cart with product
    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public static function getAllProductFromCart($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Cart::with('product')->where('user_id', $user_id)->where('order_id', null)->get();
        } else {
            return 0;
        }
    }
    // Total amount cart
    public static function totalCartPrice($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Cart::where('user_id', $user_id)->where('order_id', null)->sum('amount');
        } else {
            return 0;
        }
    }
    // Wishlist Count
    public static function wishlistCount($user_id = '')
    {

        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Wishlist::where('user_id', $user_id)->where('cart_id', null)->sum('quantity');
        } else {
            return 0;
        }
    }
    public static function getAllProductFromWishlist($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Wishlist::with('product')->where('user_id', $user_id)->where('cart_id', null)->get();
        } else {
            return 0;
        }
    }
    public static function likeCount($user_id = '')
    {

        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Like::where('user_id', $user_id)->where('cart_id', null)->sum('quantity');
        } else {
            return 0;
        }
    }
    public static function getAllProductFromLike($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Like::with('product')->where('user_id', $user_id)->where('cart_id', null)->get();
        } else {
            return 0;
        }
    }
    public static function totalLikePrice($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Like::where('user_id', $user_id)->where('cart_id', null)->sum('amount');
        } else {
            return 0;
        }
    }
    public static function totalWishlistPrice($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Wishlist::where('user_id', $user_id)->where('cart_id', null)->sum('amount');
        } else {
            return 0;
        }
    }

    // Total price with shipping and coupon
    public static function grandPrice($id, $user_id)
    {
        $order = Order::find($id);
        dd($id);
        if ($order) {
            $shipping_price = (float)$order->shipping->price;
            $order_price = self::orderPrice($id, $user_id);
            return number_format((float)($order_price + $shipping_price), 2, '.', '');
        } else {
            return 0;
        }
    }


    // Admin home
    public static function earningPerMonth()
    {
        $month_data = Order::where('status', 'delivered')->get();
        // return $month_data;
        $price = 0;
        foreach ($month_data as $data) {
            $price = $data->cart_info->sum('price');
        }
        return number_format((float)($price), 2, '.', '');
    }

    public static function shipping()
    {
        return Shipping::orderBy('id', 'DESC')->get();
    }

    public static function totalCartPrice2nd(array $selectedItemsArray)
    {
        // dd($selectedItemsArray);
        if (Auth::check()) {
            $user_id = auth()->user()->id;
            $totalAmount = Cart::where('user_id', $user_id)
                ->where('order_id', null)
                ->whereIn('id', $selectedItemsArray)
                ->sum('amount');

            return $totalAmount;
        }
    }

    public static function fetchDistanceMatrixWithUnit($userId = null)
    {
        $userId ?? auth()->user()->id;
        $userLocation = UserLocation::where('user_id', $userId)
            ->where('status', 'active')
            ->first();

        $origin = Settings::first()->pluck('address')->first();

        if ($userLocation && isset($userLocation->origin)) {

            $destination = $userLocation->origin;

            $apiKey = env('GOOGLE_MAPS_API_KEY');

            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$origin}&destinations={$destination}&units=metrics&key={$apiKey}";

            try {
                $response = Http::get($url);

                if ($response->successful()) {
                    $data = $response->json();

                    // Check if the response contains the required fields
                    if (isset($data['rows'][0]['elements'][0]['distance']['text'])) {
                        // Extract and return the distance text
                        return $data['rows'][0]['elements'][0]['distance']['text'];
                    } else {
                        return response()->json(['error' => 'Distance text not found in response'], 500);
                    }
                } else {
                    return response()->json(['error' => 'Failed to fetch distance matrix'], $response->status());
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while fetching distance matrix'], 500);
            }
        } else {
            // If user location is not set or does not have origin, return null or handle as needed
            return null;
        }
    }

    public static function fetchDistanceMatrix($userId = null)
    {
        $userId ?? auth()->user()->id;
        $userLocation = UserLocation::where('user_id', $userId)
            ->where('status', 'active')
            ->first();

        $origin = Settings::first()->pluck('address')->first();

        if ($userLocation && isset($userLocation->origin)) {
            $destination = $userLocation->origin;

            $apiKey = env('GOOGLE_MAPS_API_KEY');

            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$origin}&destinations={$destination}&units=metrics&key={$apiKey}";

            try {
                $response = Http::get($url);

                if ($response->successful()) {
                    $data = $response->json();

                    // Check if the response contains the required fields
                    if (isset($data['rows'][0]['elements'][0]['distance']['text'])) {
                        // Extract the numeric part of the distance text and convert it to an integer
                        $distanceText = $data['rows'][0]['elements'][0]['distance']['text'];
                        $distanceInteger = (int) filter_var($distanceText, FILTER_SANITIZE_NUMBER_INT);

                        // Return the integer value of the distance
                        return $distanceInteger;
                    } else {
                        return response()->json(['error' => 'Distance text not found in response'], 500);
                    }
                } else {
                    return response()->json(['error' => 'Failed to fetch distance matrix'], $response->status());
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while fetching distance matrix'], 500);
            }
        } else {
            // If user location is not set or does not have origin, return null or handle as needed
            return null;
        }
    }


    public static function getShippingPrice($userId = null)
    {
        $distance = self::fetchDistanceMatrix($userId);
        // Retrieve all shipping records ordered by distance in ascending order
        $shippings = Shipping::orderBy('distance')->get();

        // Initialize variables to store the closest price and distance
        $closestPrice = null;
        $closestDistance = null;

        // Loop through each shipping record
        foreach ($shippings as $shipping) {
            // Calculate the absolute difference between the current distance and the given distance
            $currentDistance = abs($shipping->distance - $distance);

            // If the closest distance is not set or the current distance is smaller than the closest distance
            if ($closestDistance === null || $currentDistance < $closestDistance) {
                // Update the closest price and distance with the current shipping price and distance
                $closestPrice = $shipping->price;
                $closestDistance = $currentDistance;
            }
        }

        // If a closest price is found, return it
        if ($closestPrice !== null) {
            return (int) $closestPrice;
        } else {
            // If no shipping options are available, return a default message or value
            return 'No shipping available for this distance';
        }
    }

    public static function getActiveLocation()
    {
        // Retrieve the user's active location
        $userLocation = UserLocation::where('user_id', auth()->user()->id)
            ->where('status', 'active')
            ->first();

        // Check if the user location is not null and return the origin
        if ($userLocation && isset($userLocation->origin)) {
            return $userLocation->origin;
        } else {
            // If user location is not set or does not have origin, return the default origin
            return 'Setup your Location';
        }
    }
}

?>
