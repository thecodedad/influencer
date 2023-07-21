<?php

namespace App\Influencer\Services;

use Google\Client;
use Google\Service\YouTube;
use Illuminate\Support\Arr;

class YoutubeService
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
     * @var array<int, string>
     */
    protected array $channelParts = [
        'id',
        'brandingSettings',
        'topicDetails',
        'snippet',
        'statistics',
        'status',
    ];

    /**
     * We want to retrieve these parts of the video from the API.
     *
     * @see https://developers.google.com/youtube/v3/docs/videos/list#part
     * @var array<int, string>
     */
    protected array $videoParts = [
        'id',
        'topicDetails',
        'snippet',
        'player',
        'statistics',
        'status',
        'liveStreamingDetails',
        'recordingDetails'

    ];

    public function __construct(protected string $key)
    {
        $client = new Client;

        $client->setApplicationName('Influencer Playbook');
        $client->setDeveloperKey($this->key);

        $this->youtube = new Youtube($client);
    }

    public function getChannel(string $id)
    {
        $response = $this->youtube->channels->listChannels(implode(',', $this->channelParts), [
            'id' => $id,
        ]);

        return Arr::first($response->getItems());
    }
}
