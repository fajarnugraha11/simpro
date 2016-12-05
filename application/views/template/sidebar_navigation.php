<?php
$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2);
$url_browser = ($segment2 == '') ? $segment1 : $segment1.'/'.$segment2;
?>
<ul class="navigation">
    <?php foreach($this->m_menu->ListMenu() as $row){
        $menu_name = ucwords(strtolower($row->name));
        $url = $row->url;
        $count = CountTable('backend_menu', 'parent', $row->id);
    ?>
    <li class="<?php echo (strtolower($row->url)) == $segment1 ? 'active' : ''?>">
        <a href="<?php echo ($url == '') ? '#' : site_url($url)?>"><span><?php echo $menu_name; ?></span> <i class="icon-paragraph-justify2"></i></a> <!-- menu -->
        <?php if($count != 0){ ?>
        <ul>
            <?php foreach($this->m_menu->listSubMenu() as $li) {
                $url_submenu = $li->url;
                if($li->parent == $row->id) { ?>
                    <li class="<?php echo (strtolower($li->url)) == $url_browser ? 'active' : ''?>" >
                        <a href="<?php echo ($url_submenu == '') ? '#' : site_url($url_submenu)?>">
                            <?php echo $li->name; ?>

                        </a>
                    </li>
                <?php }
            } ?>
        </ul>
        <?php } ?>
    </li>
    <?php } ?>
</ul>

