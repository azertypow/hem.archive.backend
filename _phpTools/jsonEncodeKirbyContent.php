<?php
use Kirby\Cms;
use Kirby\Cms\Page;
use Kirby\Cms\StructureObject;
include_once '_phpTools/string.php';

function getJsonEncodeFromSectionTypePlan(Page $page): array
{
    return [
        'status'=> $page->status(),
        'type'  => 'plan',
        'title' => $page->title()->value(),
        'text'  => $page->text()->value(),
        'zoneReception'       => $page->zoneReception()->value(),
        'zoneLearningLab'     => $page->zoneLearningLab()->value(),
        'zoneMakerLab'        => $page->zoneMakerLab()->value(),
        'zoneFoodLab'         => $page->zoneFoodLab()->value(),
        'zoneSchool'          => $page->zoneSchool()->value(),
        'zoneNursery'         => $page->zoneNursery()->value(),
        'zoneEntreprises'     => $page->zoneEntreprises()->value(),
    ];
}

function getJsonEncodeFromSectionTypeTeam(Page $page): array
{
    return [
        'status'=> $page->status(),
        'type'  => 'team',
        'title' => $page->title()->value(),
        'text'      => $page->text()->kirbyText()->value(),
        'partners'  => $page->partners()->toStructure()->map(
            fn($partnersItem) => getTeamItemStructure($partnersItem)
        )->data(),
    ];
}


function getJsonEncodeFromSectionTypeIntroduction(Page $page): array
{
    return [
        'status'=> $page->status(),
        'type'  => 'introduction',
        'title' => $page->title()->value(),
        'cover' => getImageArrayDataInPage($page),
        'text'  => $page->text()->value(),
        'articles' => $page->articles()->toStructure()->map(function($articleItem) {
            return [
                'image' => getImageArrayDataInPage( $articleItem ),
                'items' => $articleItem->items()->toStructure()->map(function ($textArticleItem) {
                    return $textArticleItem->text()->value();
                })->data(),
            ];
        })->data(),
    ];
}

function getJsonEncodeFromSectionTypeFoundation(Page $page): array
{
    return [
        'status'=> $page->status(),
        'type'  => 'foundation',
        'title' => $page->title()->value(),
        'cover' => getImageArrayDataInPage($page),
        'text'  => $page->text()->kirbytext()->value(),
        'team'      => $page->team()->toStructure()->map(
            fn($teamMemberItem) => getTeamItemStructure($teamMemberItem)
        )->data(),
        'conseil'      => $page->conseil()->toStructure()->map(
            fn($teamMemberItem) => getTeamItemStructure($teamMemberItem)
        )->data(),
    ];
}

function getJsonEncodeFromSectionTypeEvolution(Page $page): array
{
    return [
        'status'=> $page->status(),
        'type'      => 'evolution',
        'title'     => $page->title()->value(),
        'gallery'   => getImageArrayDataInPage($page),
        'text'      => $page->text()->kirbytext()->value(),
        'timeline'  => $page->timeline()->toStructure()->map(
            fn($timelineItem) => getTimelineItemStructure($timelineItem)
        )->data(),
    ];
}

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
        'url'       => $file->url(),
        'mediaUrl'  => $file->mediaUrl(),
        'width'     => $file->width(),
        'height'    => $file->height(),
        'resize'    => [
            'tiny'      => $file->resize(50, null, 10)->url(),
            'small'     => $file->resize(500)->url(),
            'reg'       => $file->resize(1280)->url(),
            'large'     => $file->resize(1920)->url(),
            'xxl'       => $file->resize(2500)->url(),
        ]
    ];
}

function getTimelineItemStructure(StructureObject $timelineItem): array {
    return [
        "date"          => $timelineItem->date()->value(),
        "title"         => $timelineItem->name()->value(),
        "categories"    => $timelineItem->categories()->value(),
        "text"          => $timelineItem->text()->value(),
        'cover'         => getImageArrayDataInPage($timelineItem),
    ];
}

function getTeamItemStructure(StructureObject $teamMemberItem): array {
    return [
        'name'    => $teamMemberItem->name()->value(),
        'topic'   => $teamMemberItem->topic()->value(),
        'link'    => $teamMemberItem->link()->value(),
        'email'   => $teamMemberItem->email()->value(),
        'cover'   => getImageArrayDataInPage($teamMemberItem),
        'text'    => reverseMail($teamMemberItem->text()->value()),
    ];
}

function getPreviewArticleData(Cms\Page | null $value): array | null
{
    if(!$value) return null;

    return [
    'title'             => $value->title(),
    'url'               => $value->url(),
    'slug'              => $value->slug(),
    'blueprint'         => $value->blueprint()->name(),
    'coverImage'        => getJsonEncodeImageData($value->coverImage()->toFile()),
    'typeOfContent'     => $value->typeOfContent(),
    'textIntro'         => $value->textIntro()->text(),
    'eventDate'         => $value->typeOfContent() == 'event' ? $value->eventDate() : null,
    'publicationDate'   => $value->publicationDate(),
    ];
}

function getNewsByTypeOfContent(Cms\Page $blog, string $typeOfContent): \Kirby\Toolkit\Collection {
    return $blog->children()->filterBy(fn($child) => $child->typeOfContent() == $typeOfContent);
}

function getDefaultBlogContent (Cms\Block $blockItem): array {
    return $blockItem->type() != 'image' ?
        [
            'html'      => $blockItem->toHtml(),
            'type'      => $blockItem->type(),
            'isHidden'  => $blockItem->isHidden(),
        ]
        :
        [
            'data'     => getBlogContentImageType($blockItem),
            'type'      => 'image',
            'isHidden'  => $blockItem->isHidden(),
        ];
}

function getBlogContentImageType(CMS\Block | Kirby\Cms\File $blockItem): array {

    return [
        'title'         => $blockItem->title()->value(),
        'isfixed'       => $blockItem->isfixed()->value() == 'true',
        'photographer'  => $blockItem->photographer()->value(),
        'license'       => $blockItem->license()->value(),
        'image'         => ($blockItem->image()->toFile() instanceof Kirby\Cms\File)
            ? getJsonEncodeImageData($blockItem->image()->toFile())
            : null,
    ];
}
