<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <h1>$Title</h1>
      <div>
        $Content
        $RestaurantForm
      </div>

      <div>
        <% if $Results %>
          <h2>Top results for &quot;{$Query.XML}&quot;</h2>
          <ul class="results">
            <% loop $Results %>
              <li class="results__item">
                <% include RestaurantData %>
              </li>
            <% end_loop %>
          </ul>
        <% else_if not $Results && $Query %>
          <p>
            Sorry, there are no nearby restaurants that contain &quot;{$Query.XML}&quot;
          </p>
        <% end_if %>
      </div>
    </div>
  </div>
</div>
