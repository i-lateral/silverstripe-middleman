<div id="Content" class="searchResults">
    <h1>$Title</h1>

    <% if $Query %>
        <p class="searchQuery">You searched for &quot;{$Query}&quot;</p>
    <% end_if %>

    <% if $Results %>
        <ul id="SearchResults">
            <% loop $Results %>
            <li>
                <h4>
                    <a href="$Link">
                        <% if $MenuTitle %>
                        $MenuTitle
                        <% else %>
                        $Title
                        <% end_if %>
                    </a>
                </h4>
                <% if $Content %>
                    <p>$Content.LimitWordCountXML</p>
                <% end_if %>
                <a class="readMoreLink" href="$Link" title="Read more about &quot;{$Title}&quot;">Read more about &quot;{$Title}&quot;...</a>
            </li>
            <% end_loop %>
        </ul>
    <% else %>
        <p>Sorry, your search query did not return any results.</p>
    <% end_if %>

    <% if $Results.MoreThanOnePage %>
        <ul class="pagination">
            <% if $Results.NotFirstPage %>
                <li class="prev">
                    <a href="$Results.PrevLink" title="View the previous page">
                        &larr;
                    </a>
                </li>
            <% end_if %>

            <% loop $Results.Pages %>
                <li>
                <% if $CurrentBool %>
                    <span>$PageNum</span>
                <% else %>
                    <a href="$Link" title="View page number $PageNum" class="go-to-page">
                        $PageNum
                    </a>
                <% end_if %>
                </li>
            <% end_loop %>

            <% if $Results.NotLastPage %>
                <li class="next">
                    <a href="$Results.NextLink" title="View the next page">
                        &rarr;
                    </a>
                </li>
            <% end_if %>
        </ul>
    <% end_if %>
</div>
