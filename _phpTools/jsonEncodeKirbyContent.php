<?php
use Kirby\Cms;
use Kirby\Cms\Page;
use Kirby\Cms\StructureObject;
include_once '_phpTools/string.php';

// todo: getJsonEncodeFromSectionTypeContact()

function getImageArrayDataInPage(Page|StructureObject $page): ?array
{
    return count($page->cover()->toFiles()->toArray()) > 0 ? $page->cover()->toFiles()->map(
        fn($file) => getJsonEncodeImageData($file)
    )->data() : null;
}

function getJsonEncodeImageData(Cms\File $file): array
{
    return [
        'caption'       => $file->caption()->value(),
        'alt'           => $file->alt()->value(),
        'link'          => $file->link()->value(),
        'photoCredit'   => $file->photoCredit()->value(),
        'url'           => $file->url(),
        'mediaUrl'      => $file->mediaUrl(),
        'width'         => $file->width(),
        'height'        => $file->height(),
        'resize'        => [
            'tiny'          => $file->resize(50, null, 10)->url(),
            'small'         => $file->resize(500)->url(),
            'reg'           => $file->resize(1280)->url(),
            'large'         => $file->resize(1920)->url(),
            'xxl'           => $file->resize(2500)->url(),
        ]
    ];
}

function getBlogContentImageType(CMS\Block | Kirby\Cms\File $blockItem): array {
    return [
        'caption'       => $blockItem->caption()->value(),
        'alt'           => $blockItem->alt()->value(),
        'link'          => $blockItem->link()->value(),
        'photoCredit'  => $blockItem->photoCredit()->value(),

        'type'          => $blockItem->type(),
        'isHidden'      => $blockItem->isHidden(),
        'image'         => ($blockItem->image()->toFile() instanceof Kirby\Cms\File)
            ? getJsonEncodeImageData($blockItem->image()->toFile())
            : null,
    ];
}
