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
    <div @class(["menu-item", "active" => request()->is('user/*')])
        onclick="toggleDropdown('userDropdown')">
        <i class="las la-store menu-icon"></i>
        <span>User</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="userDropdown" class="dropdown">
        <a href="{{ route('user') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-ul menu-icon"></i>
                <span>List Users</span>
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
    <div @class(["menu-item", "active" => request()->is('store/*')])
        onclick="toggleDropdown('storeDropdown')">
        <i class="las la-store menu-icon"></i>
        <span>Store</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="storeDropdown" class="dropdown">
        <a href="{{ route('store') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-ul menu-icon"></i>
                <span>List Stores</span>
            </div>
        </a>
    </div>

    <!-- Category Dropdown -->
    <div @class(["menu-item", "active" => request()->is('category/*')])
        onclick="toggleDropdown('categoryDropdown')">
        <i class="las la-box menu-icon"></i>
        <span>Category</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="categoryDropdown" class="dropdown">
        <a href="{{ route('category') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-ul menu-icon"></i>
                <span>List Categories</span>
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
    <div @class(["menu-item", "active" => request()->is('specification/*')])
        onclick="toggleDropdown('specificationDropdown')">
        <i class="las la-shopping-bag menu-icon"></i>
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
    <div @class(["menu-item", "active" => request()->is('order/*')]) onclick="toggleDropdown('orderDropdown')">
        <i class="las la-shopping-bag menu-icon"></i>
        <span>Order</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="orderDropdown" class="dropdown">
        <a href="{{ route('order') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-ul menu-icon"></i>
                <span>List Orders</span>
            </div>
        </a>
    </div>

    <!-- Chat Dropdown -->
    <div @class(["menu-item", "active" => request()->is('chat/*')]) onclick="toggleDropdown('chatDropdown')">
        <i class="las la-shopping-bag menu-icon"></i>
        <span>Chat</span>
        <i class="las la-angle-down ms-auto"></i>
    </div>
    <div id="chatDropdown" class="dropdown">
        <a href="{{ route('chat') }}" class="text-decoration-none">
            <div class="menu-item">
                <i class="las la-list-ul menu-icon"></i>
                <span>Chats</span>
            </div>
        </a>
    </div>
</div>

<script>
    function toggleDropdown(id) {
        document.getElementById(id).classList.toggle("show");
    }
</script>
