<?php

namespace partials;

/**
 * フッターを出力
 */
function footer(): void
{
    //phpここまで==============================================
?>
    </main>

    <footer class="text-center p-3">
        <span class="text-muted">&copy; CodeMafia</span>
    </footer>
    </div>
    <?php
    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
    $jsPath = $protocol . $_SERVER['HTTP_HOST'] . BASE_CONTEXT_PATH . 'js/';
    echo "<script src=\"{$jsPath}" . "form_validate.js\"></script>";
    echo "<script src=\"{$jsPath}" . "vendor/chart.js\"></script>";
    echo "<script src=\"{$jsPath}" . "pie-chart.js\"></script>";
    ?>
    <!-- <script src="js/form_validate.js"></script> -->
    </body>

    </html>
<?php
}
