<form role="search" method="get" id="searchform" class="align-items-center border-bottom border-primary mx-0 row"  action="<?= bloginfo( 'url' ); ?>/">
    <input type="text" class="col border-0 py-2 px-0 form-control" style="background: none;" name="s" id="search" placeholder="Pesquisar" value="<?= the_search_query(); ?>"/>
    <label for="send" class="col-auto"> <span class="icon-search text-primary"></span> </label>
    <input type="submit" value="post" name="post_type" id="send" class="d-none"/>
</form>
