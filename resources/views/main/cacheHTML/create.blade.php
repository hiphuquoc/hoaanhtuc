@php
    /* cache HTML */
    $name           = explode('.', $content);
    $name           = implode('-', $name);
    $nameCache      = $name.'.'.config('main.cache.extension');
    $pathCache      = Storage::path(config('main.cache.folderSave')).$nameCache;
    $cacheTime    	= env('APP_CACHE_TIME') ?? 1800;
    /* trường hợp tồn tại file cache => return */
    if(file_exists($pathCache)&&$cacheTime>(time() - filectime($pathCache))){
        $xhtml      = file_get_contents($pathCache);
        echo $xhtml;
        return false;
    }
    /* trường hợp không có file cache => mở ob */
    ob_start();
    
    echo view($content, compact('item'))->render();

    $xhtml  = ob_get_contents();
    ob_end_flush();
    if(env('APP_CACHE_HTML')==true) file_put_contents($pathCache, $xhtml);
@endphp