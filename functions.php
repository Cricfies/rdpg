function cmplz_reload_after_consent() {
    ?>
    <script>
        document.addEventListener('cmplz_status_change', function (e) {
            if (e.detail.category === 'marketing' && e.detail.value==='allow') {
                location.reload();
            }
        });

        document.addEventListener('cmplz_status_change_service', function (e) {
            if ( e.detail.value ) {
                location.reload();
            }
        });

    </script>
    <?php
}
add_action( 'wp_footer', 'cmplz_reload_after_consent' );


function cmplz_clear_cookies_on_revoke() {
	?>
	<script>
        jQuery(document).ready(function ($) {
            document.addEventListener('cmplzRevoke', function (e) {
                cmplzClearAllCookies();
            });

            /**
             * Clear all cookies
             */
            var excludeString = 'wp';
            function cmplzClearAllCookies(){
                (function () {
                    var cookies = document.cookie.split("; ");
                    for (var c = 0; c < cookies.length; c++) {
                        var d = window.location.hostname.split(".");
                        while (d.length > 0) {
                            var cookieName = cookies[c].split(";")[0].split("=")[0];
                            var cookieBase = encodeURIComponent(cookieName) + '=; expires=Thu, 01-Jan-1970 00:00:01 GMT; domain=' + d.join('.') + ' ;path=';
                            var p = location.pathname.split('/');
                            if ( cookieName.indexOf(excludeString) !==-1 ) {
                                document.cookie = cookieBase + '/';
                                while (p.length > 0) {
                                    document.cookie = cookieBase + p.join('/');
                                    p.pop();
                                };
                            }

                            d.shift();
                        }
                    }
                })();
            }

        });
	</script>
	<?php
}
add_action( 'wp_footer', 'cmplz_clear_cookies_on_revoke' );
