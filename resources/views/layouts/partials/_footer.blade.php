<?php
$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

// if $url contains 'rvm' then set $lang to 'rvm'
if (strpos(strtolower($url), 'rvm') !== false) {
    $img = 'signInLogoCallzy.jpg';
    $name = 'CALLZY';
} else if (strpos(strtolower($url), 'callzy') !== false) {
    $img = 'signInLogoCallzy.jpg';
    $name = 'CALLZY';
} else if (strpos(strtolower($url), 'voslogic') !== false) {
    $img = 'signInLogoVosLogic.jpg';
    $name = 'Vos Logic';
}
?>
<footer class="footer-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="footer-copyright">
                    <p>Copyright {{date('Y')}} by {{$name}}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="footer-menu text-right">
                    <ul>
                        <!-- <li>
                            <a href="#">About</a>
                        </li>
                        <li>
                            <a href="#">Team</a>
                        </li>
                        <li>
                            <a href="#">Contact</a>
                        </li>-->
                    </ul>
                </div>
                <!-- ends: .Footer Menu -->
            </div>
        </div>
    </div>
</footer>
