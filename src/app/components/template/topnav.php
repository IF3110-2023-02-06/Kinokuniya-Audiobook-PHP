<nav class="topnav", id="topnav">
    <div class="topnav-label">
        <i class="bx bx-grid-alt", id="topnav-page-icon"></i>
        <h4 id="topnav-page-text">Dashboard</h4>
    </div>
    <?php if (!$this->data['isAdmin']) : ?>
        <div class="topnav-menu">
            <a href="/public/cart">
                <button class="topnav-btn">
                    <i class="bx bx-cart-alt" style="color: white; font-size: 16px"></i>
                </button>
            </a>
            <a href="/public/settings" >
                <button class="topnav-btn">
                    <i class="bx bx-cog" style="color: white; font-size: 16px"></i>
                </button>
            </a>
        </div>
    <?php endif ?>
</nav>