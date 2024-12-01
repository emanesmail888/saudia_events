<div>
    <?php
    // Get the full request URI
    $requestUri = request()->getRequestUri();

    // Parse the request URI to extract the query string
    $parsedUrl = parse_url($requestUri);

    // Parse the query string to get the 'resourcePath' value
    $queryParams = [];
    parse_str($parsedUrl['query'], $queryParams);

    $resourcePath = $queryParams['resourcePath'];
    ?>

    @if (Session::has('success'))
        <div class="alert alert-success " role="alert">{{Session::get('success')}}
        </div>
    @else
        <div class="alert alert-danger " role="alert">{{Session::get('fail')}}
        </div>
    @endif
</div>
