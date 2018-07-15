<header>
  <div class="container">
    <% if $Menu(1) %>
      <nav>
        <ul>
          <% loop $Menu(1) %>
            <li>
              <a href="$Link">$MenuTitle</a>
            </li>
          <% end_loop %>
        </ul>
      </nav>
    <% end_if %>
  </div>
</header>
