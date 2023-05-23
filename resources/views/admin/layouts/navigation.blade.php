<nav id="left-sidebar-nav" class="sidebar-nav">
    <ul id="main-menu" class="metismenu">

        <li class="{{(Route::currentRouteName() == 'admin.dashboard') ? 'active' : ''}}"><a href="{{route('admin.dashboard')}}"><i class="fa fa-home" aria-hidden="true"></i><span>Dashboard</span></a></li>
        <li><a target="_blank" href="{{route('index')}}"><i class="fa fa-globe" aria-hidden="true"></i><span>Frontend</span></a></li>
        {{-- Super Admin Panel Start --}}
        @if (Auth::guard('admin')->user()->role == 'Super Admin')
        <span class="mb-2 badge badge-info">Super Admin Panel</span>
        <li class="{{(Route::currentRouteName() == 'all.customer') ? 'active' : ''}}"><a href="{{route('all.customer')}}"><i class="fa fa-users" aria-hidden="true"></i><span>All Customer</span></a></li>
        <li class="{{(Route::currentRouteName() == 'contact.message') ? 'active' : ''}}"><a href="{{route('contact.message')}}"><i class="fa fa-envelope-o" aria-hidden="true"></i><span>Contact Message</span></a></li>

        <li class="{{(Route::currentRouteName() == 'all.subscriber' || Route::currentRouteName() == 'all.newsletter') ? 'active' : ''}}">
            <a href="#Subscriber" class="has-arrow"><i class="fa fa-envelope-o" aria-hidden="true"></i><span>Subscriber</span></a>
            <ul>
                <li class="{{(Route::currentRouteName() == 'all.subscriber') ? 'active' : ''}}"><a href="{{route('all.subscriber')}}">All Subscriber</a></li>
                <li class="{{(Route::currentRouteName() == 'all.newsletter') ? 'active' : ''}}"><a href="{{route('all.newsletter')}}">All Newsletter</a></li>
            </ul>
        </li>
        <li class="{{(Route::currentRouteName() == 'report.all.order' || Route::currentRouteName() == 'report.product.inventory') ? 'active' : ''}}">
            <a href="#AllReport" class="has-arrow"><i class="fa fa-sitemap" aria-hidden="true"></i><span>All Report</span></a>
            <ul>
                <li class="{{(Route::currentRouteName() == 'report.all.order') ? 'active' : ''}}"><a href="{{route('report.all.order')}}">All Order</a></li>
                <li class="{{(Route::currentRouteName() == 'report.product.inventory') ? 'active' : ''}}"><a href="{{route('report.product.inventory')}}">Product Inventory</a></li>
            </ul>
        </li>
        <li class="{{(Route::currentRouteName() == 'mail.setting' || Route::currentRouteName() == 'default.setting' || Route::currentRouteName() == 'social-login.setting' || Route::currentRouteName() == 'payment.setting' || Route::currentRouteName() == 'seo.setting' || Route::currentRouteName() == 'sms.setting' || Route::currentRouteName() == 'page-setting.index' || Route::currentRouteName() == 'page-setting.create' || Route::currentRouteName() == 'page-setting.edit' || Route::currentRouteName() == 'page-setting.show') ? 'active' : ''}}">
            <a href="#Setting" class="has-arrow"><i class="fa fa-cog" aria-hidden="true"></i><span>Setting</span></a>
            <ul>
                <li class="{{(Route::currentRouteName() == 'default.setting') ? 'active' : ''}}"><a href="{{route('default.setting')}}">Default Setting</a></li>
                <li class="{{(Route::currentRouteName() == 'mail.setting') ? 'active' : ''}}"><a href="{{route('mail.setting')}}">Mail Setting</a></li>
                <li class="{{(Route::currentRouteName() == 'payment.setting') ? 'active' : ''}}"><a href="{{route('payment.setting')}}">Payment Setting</a></li>
                <li class="{{(Route::currentRouteName() == 'social-login.setting') ? 'active' : ''}}"><a href="{{route('social-login.setting')}}">Social Login Setting</a></li>
                <li class="{{(Route::currentRouteName() == 'seo.setting') ? 'active' : ''}}"><a href="{{route('seo.setting')}}">Seo Setting</a></li>
                <li class="{{(Route::currentRouteName() == 'sms.setting') ? 'active' : ''}}"><a href="{{route('sms.setting')}}">Sms Setting</a></li>
                <li class="{{(Route::currentRouteName() == 'page-setting.index' || Route::currentRouteName() == 'page-setting.create' || Route::currentRouteName() == 'page-setting.edit' || Route::currentRouteName() == 'page-setting.show') ? 'active' : ''}}"><a href="{{route('page-setting.index')}}">Page Setting</a></li>
            </ul>
        </li>
        <li class="{{(Route::currentRouteName() == 'administration.register' || Route::currentRouteName() == 'all.administration') ? 'active' : ''}}">
            <a href="#Administration" class="has-arrow"><i class="fa fa-cog" aria-hidden="true"></i><span>Administration</span></a>
            <ul>
                <li class="{{(Route::currentRouteName() == 'administration.register') ? 'active' : ''}}"><a href="{{route('administration.register')}}">Administration Register</a></li>
                <li class="{{(Route::currentRouteName() == 'all.administration') ? 'active' : ''}}"><a href="{{route('all.administration')}}">All Administration</a></li>
            </ul>
        </li>
        @endif
        {{-- Super Admin Panel End --}}
        {{-- Admin Panel Start--}}
        @if (Auth::guard('admin')->user()->role != 'Warehouse')
        <span class="mb-2 badge badge-info">Admin Panel</span>
        <li class="{{(Route::currentRouteName() == 'category.index' || Route::currentRouteName() == 'subcategory.index' || Route::currentRouteName() == 'childcategory.index' || Route::currentRouteName() == 'brand.index' || Route::currentRouteName() == 'color.index' || Route::currentRouteName() == 'size.index' || Route::currentRouteName() == 'product.index' || Route::currentRouteName() == 'coupon.index' || Route::currentRouteName() == 'flashsale.index' || Route::currentRouteName() == 'shipping.index' || Route::currentRouteName() == 'flashsale.product.added') ? 'active' : ''}}">
            <a href="#ProductResource" class="has-arrow"><i class="fa fa-file" aria-hidden="true"></i><span>Product Resource</span></a>
            <ul>
                <li class="{{(Route::currentRouteName() == 'category.index') ? 'active' : ''}}"><a href="{{route('category.index')}}">Category</a></li>
                <li class="{{(Route::currentRouteName() == 'subcategory.index') ? 'active' : ''}}"><a href="{{route('subcategory.index')}}">Subcategory</a></li>
                <li class="{{(Route::currentRouteName() == 'childcategory.index') ? 'active' : ''}}"><a href="{{route('childcategory.index')}}">Childcategory</a></li>
                <li class="{{(Route::currentRouteName() == 'brand.index') ? 'active' : ''}}"><a href="{{route('brand.index')}}">Brand</a></li>
                <li class="{{(Route::currentRouteName() == 'color.index') ? 'active' : ''}}"><a href="{{route('color.index')}}">Color</a></li>
                <li class="{{(Route::currentRouteName() == 'size.index') ? 'active' : ''}}"><a href="{{route('size.index')}}">Size</a></li>
                <li class="{{(Route::currentRouteName() == 'product.index') ? 'active' : ''}}"><a href="{{route('product.index')}}">Product</a></li>
                <li class="{{(Route::currentRouteName() == 'coupon.index') ? 'active' : ''}}"><a href="{{route('coupon.index')}}">Coupon</a></li>
                <li class="{{(Route::currentRouteName() == 'flashsale.index' || Route::currentRouteName() == 'flashsale.product.added') ? 'active' : ''}}"><a href="{{route('flashsale.index')}}">Flashsale</a></li>
                <li class="{{(Route::currentRouteName() == 'shipping.index') ? 'active' : ''}}"><a href="{{route('shipping.index')}}">Shipping</a></li>
            </ul>
        </li>
        <li class="{{(Route::currentRouteName() == 'blog_category.index' || Route::currentRouteName() == 'blog.index') ? 'active' : ''}}">
            <a href="#BlogResource" class="has-arrow"><i class="fa fa-rss" aria-hidden="true"></i><span>Blog Resource</span></a>
            <ul>
                <li class="{{(Route::currentRouteName() == 'blog_category.index') ? 'active' : ''}}"><a href="{{route('blog_category.index')}}">Category</a></li>
                <li class="{{(Route::currentRouteName() == 'blog.index') ? 'active' : ''}}"><a href="{{route('blog.index')}}">Blog</a></li>
            </ul>
        </li>
        <li class="{{(Route::currentRouteName() == 'slider.index' || Route::currentRouteName() == 'feature.index' || Route::currentRouteName() == 'faq.index' || Route::currentRouteName() == 'banner.index' || Route::currentRouteName() == 'team.index' || Route::currentRouteName() == 'warehouse.index') ? 'active' : ''}}">
            <a href="#OtherResource" class="has-arrow"><i class="fa fa-sitemap" aria-hidden="true"></i><span>Other Resource</span></a>
            <ul>
                <li class="{{(Route::currentRouteName() == 'slider.index') ? 'active' : ''}}"><a href="{{route('slider.index')}}">Slider</a></li>
                <li class="{{(Route::currentRouteName() == 'feature.index') ? 'active' : ''}}"><a href="{{route('feature.index')}}">Feature</a></li>
                <li class="{{(Route::currentRouteName() == 'faq.index') ? 'active' : ''}}"><a href="{{route('faq.index')}}">Faq</a></li>
                <li class="{{(Route::currentRouteName() == 'banner.index') ? 'active' : ''}}"><a href="{{route('banner.index')}}">Banner</a></li>
                <li class="{{(Route::currentRouteName() == 'team.index') ? 'active' : ''}}"><a href="{{route('team.index')}}">Team</a></li>
                <li class="{{(Route::currentRouteName() == 'warehouse.index') ? 'active' : ''}}"><a href="{{route('warehouse.index')}}">Warehouse</a></li>
            </ul>
        </li>
        @endif
        {{-- Admin Panel End--}}
        {{-- Warehouse Panel Start--}}
        @if (Auth::guard('admin')->user()->role != 'Super Admin')
        <span class="mb-2 badge badge-info">Warehouse Panel</span>
        <li class="{{(Route::currentRouteName() == 'processing.orders' || Route::currentRouteName() == 'delivered.orders' || Route::currentRouteName() == 'cancel.orders' || Route::currentRouteName() == 'return.orders') ? 'active' : ''}}">
            <a href="#AllOrders" class="has-arrow"><i class="fa fa-sitemap" aria-hidden="true"></i><span>All Orders</span></a>
            <ul>
                <li class="{{(Route::currentRouteName() == 'processing.orders') ? 'active' : ''}}"><a href="{{route('processing.orders')}}">Processing Order</a></li>
                <li class="{{(Route::currentRouteName() == 'delivered.orders') ? 'active' : ''}}"><a href="{{route('delivered.orders')}}">Delivered Orders</a></li>
                @if (Auth::guard('admin')->user()->role != 'Warehouse')
                <li class="{{(Route::currentRouteName() == 'cancel.orders') ? 'active' : ''}}"><a href="{{route('cancel.orders')}}">Cancel Orders</a></li>
                <li class="{{(Route::currentRouteName() == 'return.orders') ? 'active' : ''}}"><a href="{{route('return.orders')}}">Return Orders</a></li>
                @endif
            </ul>
        </li>
        @endif
        {{-- Warehouse Panel End--}}
    </ul>
</nav>
