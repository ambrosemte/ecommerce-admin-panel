<style>
    .sidebar {
        width: 250px;
        background: #f8f9fa;
        /* Matches Bootstrap light topbar */
        color: #202224;
        padding: 20px;
        height: 100vh;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
        position: fixed;
        top: 0;
        left: 0;
    }

    .logo {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 30px;
        color: #0d6efd;
    }

    .menu-item {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s;
        color: #343a40;
        margin: 5px 0;
    }

    .menu-item:hover,
    .menu-item.active {
        background-color: #e2e6ea;
        color: #343a40;
    }

    .menu-icon {
        margin-right: 12px;
        font-size: 18px;
        color: #0d6efd;
    }

    .dropdown {
        display: none;
        padding-left: 25px;
        margin-top: 5px;
    }

    .dropdown.show {
        display: block;
    }

    .dropdown .menu-item {
        padding: 8px 12px;
        font-size: 15px;
        color: #495057;
    }

    .dropdown .menu-item:hover {
        background-color: #dee2e6;
    }
</style>


<div class="sidebar">
    <div class="logo">Admin<span style="color:#202224">Panel</span></div>

    <a href="{{ route('dashboard') }}" class="text-decoration-none">
        <div @class(["menu-item", "active" => request()->is('dashboard')])>
            <i class="las la-tachometer-alt menu-icon"></i>
            <span>Dashboard</span>
        </div>
    </a>

    <!-- User Dropdown -->
    <div @class(["menu-item", "active" => request()->is('user') || request()->is('user/*')])
        onclick="toggleDropdown('userDropdown')">
        <i class="las la-user menu-icon"></i>
        <span>User</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="userDropdown" class="dropdown">
        <a href="{{ route('user') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-ul menu-icon"></i>
                <span>Users List</span>
            </div>
        </a>
        <a href="{{ route('user') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-plus-circle menu-icon"></i>
                <span>Create User</span>
            </div>
        </a>
    </div>

    <!-- Store Dropdown -->
    <div @class(["menu-item", "active" => request()->is('store') || request()->is('store/*')])
        onclick="toggleDropdown('storeDropdown')">
        <i class="las la-store menu-icon"></i>
        <span>Store</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="storeDropdown" class="dropdown">
        <a href="{{ route('store') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-ul menu-icon"></i>
                <span>Stores List</span>
            </div>
        </a>
    </div>

    <!-- Product Dropdown -->
    <div @class(["menu-item", "active" => request()->is('product') || request()->is('product/*')])
        onclick="toggleDropdown('productDropdown')">
        <i class="las la-box menu-icon"></i>
        <span>Product</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="productDropdown" class="dropdown">
        <a href="{{ route('product') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-ul menu-icon"></i>
                <span>Products List</span>
            </div>
        </a>
    </div>

    <!-- Category Dropdown -->
    <div @class(["menu-item", "active" => request()->is('category') || request()->is('category/*')])
        onclick="toggleDropdown('categoryDropdown')">
        <i class="las la-th-large menu-icon"></i>
        <span>Category</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="categoryDropdown" class="dropdown">
        <a href="{{ route('category') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-ul menu-icon"></i>
                <span>Categories List</span>
            </div>
        </a>
        <a href="{{ route('category.create') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-plus-circle menu-icon"></i>
                <span>Create Category</span>
            </div>
        </a>
    </div>

    <!-- Specification Dropdown -->
    <div @class(["menu-item", "active" => request()->is('specification') || request()->is('specification/*')])
        onclick="toggleDropdown('specificationDropdown')">
        <i class="las la-clipboard-list menu-icon"></i>
        <span>Specification</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="specificationDropdown" class="dropdown">
        <a href="{{ route('specification.create') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-plus-circle menu-icon"></i>
                <span>Create Specification</span>
            </div>
        </a>
    </div>

    <!-- Orders Dropdown -->
    <div @class(["menu-item", "active" => request()->is('order') || request()->is('order/*')])
        onclick="toggleDropdown('orderDropdown')">
        <i class="las la-shopping-bag menu-icon"></i>
        <span>Order</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="orderDropdown" class="dropdown">
        <a href="{{ route('order') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-ul menu-icon"></i>
                <span>Orders List</span>
            </div>
        </a>
    </div>

     <!-- Story Dropdown -->
    <div @class(["menu-item", "active" => request()->is('story') || request()->is('story/*')])
        onclick="toggleDropdown('storyDropdown')">
        <i class="las la-dot-circle menu-icon"></i>
        <span>Story</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="storyDropdown" class="dropdown">
        <a href="{{ route('story') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-alt menu-icon"></i>
                <span>Stories List</span>
            </div>
        </a>
    </div>

    <!-- Promo Banner Dropdown -->
    <div @class(["menu-item", "active" => request()->is('promo-banner') || request()->is('promo-banner/*')])
        onclick="toggleDropdown('promoBannerDropdown')">
        <i class="las la-bullhorn menu-icon"></i>
        <span>Promo Banner</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="promoBannerDropdown" class="dropdown">
        <a href="{{ route('promo.banner') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-alt menu-icon"></i>
                <span>Promo Banner List</span>
            </div>
        </a>
    </div>

    <!-- Reviews Dropdown -->
    <div @class(["menu-item", "active" => request()->is('review')]) onclick="toggleDropdown('reviewDropdown')">
        <i class="las la-edit menu-icon"></i>
        <span>Review</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="reviewDropdown" class="dropdown">
        <a href="{{ route('review') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-ul menu-icon"></i>
                <span>Reviews List</span>
            </div>
        </a>
    </div>

    <!-- Shiping Dropdown -->
    <div @class(["menu-item", "active" => request()->is('shipping/method*')])
        onclick="toggleDropdown('shippingMethodDropdown')">
        <i class="las la-car menu-icon"></i>
        <span>Shipping Methods</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="shippingMethodDropdown" class="dropdown">
        <a href="{{ route('shipping.method') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-ul menu-icon"></i>
                <span>Shipping Methods List</span>
            </div>
        </a>
        <a href="{{ route('shipping.method.create') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-plus-circle menu-icon"></i>
                <span>Create Shipping Method</span>
            </div>
        </a>
    </div>

    <!-- Shiping Zone -->
    <div @class(["menu-item", "active" => request()->is('shipping/zone*')])
        onclick="toggleDropdown('shippingZoneDropdown')">
        <i class="las la-map-marker menu-icon"></i>
        <span>Shipping Zones</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="shippingZoneDropdown" class="dropdown">
        <a href="{{ route('shipping.zone') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-ul menu-icon"></i>
                <span>Shipping Zones List</span>
            </div>
        </a>
        <a href="{{ route('shipping.zone.create') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-plus-circle menu-icon"></i>
                <span>Create Shipping Zone</span>
            </div>
        </a>
    </div>

    <!-- Shiping Rates -->
    <div @class(["menu-item", "active" => request()->is('shipping/rate*')])
        onclick="toggleDropdown('shippingRateDropdown')">
        <i class="las la-dollar-sign menu-icon"></i>
        <span>Shipping Rates</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="shippingRateDropdown" class="dropdown">
        <a href="{{ route('shipping.rate') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-ul menu-icon"></i>
                <span>Shipping Rates List</span>
            </div>
        </a>
    </div>

    <!-- Chat Dropdown -->
    <div @class(["menu-item", "active" => request()->is('chat') || request()->is('chat/*')])
        onclick="toggleDropdown('chatDropdown')">
        <i class="las la-comments menu-icon"></i>
        <span>Chat</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="chatDropdown" class="dropdown">
        <a href="{{ route('chat') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-ul menu-icon"></i>
                <span>All Chats</span>
            </div>
        </a>
    </div>
</div>

<script>
    function toggleDropdown(id) {
        document.getElementById(id).classList.toggle("show");
    }
</script>
