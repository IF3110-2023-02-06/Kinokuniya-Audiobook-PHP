<div class="sidebar">
    <div class="logo-details">
        <div class="logo_name">Kinokuniya</div>
        <i class='bx bx-menu' id="btn"></i>
    </div>
    <?php if (!$this->data['isAdmin']) : ?>
        <ul class="nav-list">
            <li>
                <a href="/public/home" >
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="/public/catalogue" >
                    <i class='bx bx-library'></i>
                    <span class="links_name">Catalogue</span>
                </a>
                <span class="tooltip">Catalogue</span>
            </li>
            <li>
                <a href="/public/mybooks" >
                    <i class='bx bx-book'></i>
                    <span class="links_name">My Books</span>
                </a>
                <span class="tooltip">My Books</span>
            </li>
            <li>
                <a id="log-out">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Log Out</span>
                </a>
                <span class="tooltip">Log Out</span>
            </li>
        </ul>
    <?php else : ?>
        <ul class="nav-list">
            <li>
                <a href="/public/catalogue/control" >
                    <i class='bx bx-library'></i>
                    <span class="links_name">Catalogue Control</span>
                </a>
                <span class="tooltip">Catalogue Control</span>
            </li>
            <li>
                <a href="/public/user" >
                    <i class='bx bx-user'></i>
                    <span class="links_name">User Control</span>
                </a>
                <span class="tooltip">User Control</span>
            </li>
            <li>
                <a id="log-out">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Log Out</span>
                </a>
                <span class="tooltip">Log Out</span>
            </li>
        </ul>
    <?php endif; ?>
</div>
