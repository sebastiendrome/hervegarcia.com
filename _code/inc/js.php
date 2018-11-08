<!-- jQuery -->
<script type="text/javascript" src="/_code/js/jquery-3.2.1.min.js" charset="utf-8"></script>
<!-- common custom js -->
<script type="text/javascript" src="/_code/js/js.js?v=<?php echo $version; ?>" charset="utf-8"></script>
<?php
// animate sub-nav, only for nav-left
if(SHOW_SUB_NAV == 'yes' && CSS == 'nav-left'){
    ?>
    <script type="text/javascript">
    $('#nav ul li.selected ul').css('height', 'auto');
    $('#nav ul li:not(.selected) a').on('click', function(e){
        var $ul = $(this).parent().children('ul');
        $ul.css('height', 'auto');
        var autoHeight = $ul.height();
        $ul.height(0).stop().animate({height: autoHeight}, 300);
        limitNavHeight(); // added in case drop downs cause nav to exceed page height
        e.preventDefault();
    })/*.on('mouseleave', function(){
        var $ul = $(this).children('ul');
        $ul.stop().animate({height: 0}, 300);
    })*/;
    </script>
    <?php
}
?>