<?php
//
//use  Kirby\Cms\App as KirbyApp;
//
//try {
//    KirbyApp::plugin('azertypow/create-zip-archive', [
//            'hooks' => [
//
//                'file.*:after' => function (Kirby\Cms\File $file) {
//                    //  inspired by https://github.com/joachimesque/kirby-zipdownload/blob/master/kirby-zipdownload.php
//
//                    $zipFileDirectory = dirname($file->root());
//
//                    # create new zip object
//                    $zip = new ZipArchive();
//
//                    # create a temp file & open it
//                    $zipFileName = $zipFileDirectory.'/hem_files.zip';
//
//                    error_log(print_r($zipFileName, true));
//
//                    $zip->open($zipFileName, ZipArchive::CREATE);
//                    $zip->addEmptyDir('hem_files');
//                    $zip->addFromString('hem_files/'.$file->filename(), file_get_contents($file->root()));
//
//                    # close zip
//                    $zip->close();
//
////                    # send the file to the browser as a download
////                    header('Content-disposition: attachment; filename=download.zip');
////                    header('Content-type: application/zip');
////                    readfile($zipFileName);
//
//                }
//            ]]
//    );
//} catch (\Kirby\Exception\DuplicateException $e) {
//
//}
//
