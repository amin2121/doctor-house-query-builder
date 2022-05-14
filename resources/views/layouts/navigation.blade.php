<ul class="navbar-nav mr-auto">
    <li class="nav-item">
      <a class="nav-link{{ request()->is('/') ? ' active' : '' }}" aria-current="page" href="/">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link{{ request()->is('posts') ? ' active' : '' }}" href="/posts">Posts</a>
    </li>
    <li class="nav-item">
      <a class="nav-link{{ request()->is('about') ? ' active' : '' }}" href="/about">About</a>
    </li>
    <li class="nav-item">
      <a class="nav-link{{ request()->is('contact') ? ' active' : '' }}" href="/contact">Contact</a>
    </li>
</ul>