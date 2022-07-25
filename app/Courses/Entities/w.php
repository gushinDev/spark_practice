<?php

class Content implements JsonSerializable
{
    private array $texts;
    private array $linksToTheArticles;
    private array $linksToTheVideos;

    /**
     * @param array $text
     * @param array $linkToTheArticle
     * @param array $linkToTheVideo
     */
    public function __construct(array $text = [], array $linkToTheArticle = [], array $linkToTheVideo = [])
    {
        $this->texts = $text;
        $this->linksToTheArticles = $linkToTheArticle;
        $this->linksToTheVideos = $linkToTheVideo;
    }

    /**
     * @return array
     */
    public function getTexts(): array
    {
        return $this->texts;
    }

    /**
     * @param array $texts
     */
    public function setTexts(array $texts): void
    {
        $this->texts = $texts;
    }

    /**
     * @return array
     */
    public function getLinksToTheArticles(): array
    {
        return $this->linksToTheArticles;
    }

    /**
     * @param array $linksToTheArticles
     */
    public function setLinksToTheArticles(array $linksToTheArticles): void
    {
        $this->linksToTheArticles = $linksToTheArticles;
    }

    /**
     * @return array
     */
    public function getLinksToTheVideos(): array
    {
        return $this->linksToTheVideos;
    }

    /**
     * @param array $linksToTheVideos
     */
    public function setLinksToTheVideos(array $linksToTheVideos): void
    {
        $this->linksToTheVideos = $linksToTheVideos;
    }

    public function jsonSerialize(): array
    {
        $array = [];
        foreach ($this->texts as $text) {
            $array[] = [
              'type' => 'text',
              'content' => $text
            ];
        }
        foreach ($this->linksToTheArticles as $linkToTheArticle) {
            $array[] = [
              'type' => 'linkToTheArticle',
              'content' => $linkToTheArticle
            ];
        }
        foreach ($this->linksToTheVideos as $linkToTheVideo) {
            $array[] = [
              'type' => 'linkToTheVideo',
              'content' => $linkToTheVideo
            ];
        }

        return $array;
    }

    public function setContentFieldsWithJson(string $jsonContent): void
    {
        $array = json_decode($jsonContent, JSON_OBJECT_AS_ARRAY);
        $texts = [];
        $linksToTheArticles = [];
        $linksToTheVideos = [];

        foreach ($array as $item) {
            switch ($item['type']) {
                case "text":
                    $texts[] = $item['content'];
                    break;
                case "linkToTheArticle":
                    $linksToTheArticles[] = $item['content'];
                    break;
                case "linkToTheVideo":
                    $linksToTheVideos[] = $item['content'];
                    break;
                default:
                    break;
            }
        }
        $this->texts = $texts;
        $this->linksToTheArticles = $linksToTheArticles;
        $this->linksToTheVideos = $linksToTheVideos;
    }


}