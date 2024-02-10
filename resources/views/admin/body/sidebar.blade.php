<nav class="sidebar">
      <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
          Labo<span>Charaf</span>
        </a>
        <div class="sidebar-toggler not-active">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <div class="sidebar-body">
        <ul class="nav">
          <li class="nav-item nav-category">Main</li>
          <li class="nav-item">
            <a href="{{route('dashtest')}}" class="nav-link">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('products.index')}}" class="nav-link">
              <i class="link-icon" data-feather="package"></i>
              <span class="link-title">Products</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('transactions.index')}}" class="nav-link">
              <i class="link-icon" data-feather="activity"></i>
              <span class="link-title">Transactions</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('products.low-stock-alerts')}}" class="nav-link">
              <i class="link-icon" data-feather="alert-octagon"></i>
              <span class="link-title">Alerts</span>
            </a>
          </li>
          
        </ul>
      </div>
    </nav>
   