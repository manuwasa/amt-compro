<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Old-domain (abcjayasejahtera.com) SEO-equity redirects
|--------------------------------------------------------------------------
| The old WordPress site's content — PT ABC Jaya Sejahtera's profile and
| contact info — now lives under this new AMT Group site's
| /our-services/pt-abc-jaya-sejahtera subtree instead of the root. These
| 301s preserve any existing search ranking/backlinks once abcjayasejahtera.com's
| DNS is pointed at this app (or the old domain is kept alive solely to redirect).
| The domain root itself is intentionally NOT redirected: it now serves the new
| AMT Group homepage, which is a distinct page from PT ABC Jaya Sejahtera's profile.
|
| IMPORTANT — Laravel normalizes trailing slashes on both route registration
| and incoming-request matching, so "/x" and "/x/" are literally the same
| route; there is no way to redirect one to the other. That means old paths
| whose slug is unchanged in the new site (/products/, /contact/, and each
| product page /products/{slug}/) need NO redirect at all — the real routes
| already serve them directly. Only add a redirect here for an old path that
| is textually different from its new equivalent, such as the two below.
|
| Before activating at cutover, verify these against the client's web server
| logs or Google Search Console — WordPress permalink slugs can vary.
*/

Route::redirect('/about-us', '/our-services/pt-abc-jaya-sejahtera', 301);
Route::redirect('/services', '/our-services', 301);
