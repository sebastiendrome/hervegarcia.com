<!-- jQuery -->
<script type="text/javascript" src="/_code/js/jquery-3.2.1.min.js" charset="utf-8"></script>
<!-- common custom js -->
<script type="text/javascript" src="/_code/js/js.js?v=<?php echo $version; ?>" charset="utf-8"></script>

<!-- dynamic images size, based on js wW and wH (window width and height) -->
<script type="text/javascript">
document.write("<style type='text/css'>img.responsive{max-width:"+max_w+"px; max-height:"+max_h+"px;/* object-fit:contain;*/}</style>");
</script>

<?php
// animate sub-nav, only for nav-left
if(SHOW_SUB_NAV == 'yes' && CSS == 'nav-left'){
    ?>
    <script type="text/javascript">
    // make sure selected top-nav items show their sub-items
    //$('#nav ul li.selected ul').css('height', 'auto');
    // prevent top level selected nav items from linking to their page
    $('#nav ul li.selected > a').on('click', function(e){
        e.preventDefault();
    });
    // when click on top-nav item, if it contains sub-items, show them (via animate height)
    $('#nav ul li:not(.selected)').on('click', function(){
        var $ul = $(this).children('ul');
        if($ul.length > 0){
            $(this).children('a').attr('href','javascript:;');
            //alert('oui ul');
            var thisHeight = $ul.height();
            //alert(thisHeight);
            $ul.css('height', 'auto');
            var autoHeight = $ul.height();
            $ul.css('height', 0);
            //alert(autoHeight);
            if(autoHeight !== thisHeight){ // nav is NOT selected (it is closed, open it)
                $ul.animate({height: autoHeight}, 300);
            }else{  // nav IS selected (it is open, close it)
                $ul.css('height', autoHeight);
                $ul.animate({height: 0}, 300);
            }
            limitNavHeight(); // added in case drop downs cause nav to exceed page height
        }
    });
    </script>
    <?php
}
?>