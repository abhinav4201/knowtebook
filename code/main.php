<?php
if(!$loggedin)
{ die(header('location:index.php'));}
?>
<div id="fakebox" style="<?php echo $style;?>">
    <form data-ajax="false" class="c02" method="POST" action="<?php echo sanitizeString(htmlspecialchars($_SERVER['PHP_SELF']));?>">
        <div class="p01 ui-field-contain">
            <label for="in04" class="ui-hidden-accessible"></label><input type="text" onFocus="css()" class="in04" name="query" onKeyup="Query(this)" data-shadow="false" data-corner="false" data-inset="false" data-corner="false" placeholder="Enter Notes Title" aria-label="Enter Notes Title" >
            <button type="submit" class="b05  ui-btn-inline" aria-hidden="true" aria-disabled="true" aria-label="Search Notes" tabindex="-1">
                <span id="b06">
                    <?xml ?>
                    <!-- Generator: Adobe Illustrator 16.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        width="14px" height="14px" viewBox="0 0 14 14" style="enable-background:new 0 0 14 14;" xml:space="preserve">
                        <path d="M10.171,8.766c0.617-0.888,0.979-1.964,0.979-3.126c0-3.037-2.463-5.5-5.5-5.5s-5.5,2.463-5.5,5.5s2.463,5.5,5.5,5.5
                        c1.152,0,2.223-0.355,3.104-0.962l3.684,3.683l1.414-1.414L10.171,8.766z M5.649,9.14c-1.933,0-3.5-1.567-3.5-3.5
                        c0-1.933,1.567-3.5,3.5-3.5c1.933,0,3.5,1.567,3.5,3.5C9.149,7.572,7.582,9.14,5.649,9.14z"/>
                    </svg>
                </span>
            </button>
        </div>
    </form>
</div>
