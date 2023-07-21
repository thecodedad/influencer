<?php

namespace App\Influencer\Services;

use Google\Client;
use Google\Service\YouTube;
use Google\Service\YouTube\Channel;
use Illuminate\Support\Arr;

class YouTubeService
{
    /**
     * The Youtube API client that will be used to make requests.
     *
     * @see https://github.com/googleapis/google-api-php-client-services/tree/main/src/YouTube
     */
    protected Youtube $youtube;

    /**
     * We want to retrieve these parts of the channel from the API.
     *
     * @see https://developers.google.com/youtube/v3/docs/channels/list#part
     *
     * @var array<int, string>
     */
    protected array $channelParts = [
        'id',
        'snippet',
        'statistics',
    ];

    /**
     * We want to retrieve these parts of the video from the API.
     *
     * @see https://developers.google.com/youtube/v3/docs/videos/list#part
     *
     * @var array<int, string>
     */
    protected array $videoParts = [
        'id',
        'snippet',
        'statistics',

    ];

    public function __construct(protected string $key)
    {
        $client = new Client;

        $client->setApplicationName('Influencer Playbook');
        $client->setDeveloperKey($this->key);

        $this->youtube = new Youtube($client);
    }

    public function getChannelById(string $id): Channel
    {
        $response = $this->youtube->channels->listChannels(implode(',', $this->channelParts), [
            'id' => $id,
        ]);

        return Arr::first($response->getItems());
    }

    public function getVideosByChannel(string $channelId, string $pageToken = null): array
    {
        $response = $this->youtube->search->listSearch('id', [
            'channelId' => $channelId,
            'type' => 'video',
            'maxResults' => 50,
            'pageToken' => $pageToken,
        ]);

        $videos = $response->getItems();

        if ($response->nextPageToken) {
            $videos = array_merge($videos, $this->getVideosByChannel($channelId, $response->nextPageToken));
        }

        return $videos;
    }

    public function getVideoById(string $id)
    {
        $response = $this->youtube->videos->listVideos(implode(',', $this->videoParts), [
            'id' => $id,
        ]);

        return Arr::first($response->getItems());
    }
}
