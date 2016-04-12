<?php
namespace Twitch\Controllers;

use Pimple\Container;
use Symfony\Component\HttpFoundation\Response;
use Twitch\Services\TwitchKraken;

class Main extends AbstractController
{
    /**
     * Index
     * @throws \Exception
     */
    public function index()
    {
        $this->response->setContent($this->twig->render('index.html.twig',
            ['games' => $this->getTwitchService()->getGames()]));

    }

    /**
     *
     */
    public function json()
    {
        echo json_encode($this->getTwitchService()->getGames());
    }

    public function game($args)
    {
        $result = array();
        if (array_key_exists('id', $args)) {
            $result = $this->getTwitchService()->searchGame($args['id']);
        }
        echo json_encode($result);
//        $this->response->setContent($this->twig->render('games.html.twig',
//            ['game_list' => $result]));
    }

    public function product($args)
    {
        $data = $args['id'];
        if ($data == 0) {
            $result = [
              ["value" => 0, "label" => "All"],
              ["value" => 1, "label" => "PckeeperLive2014"],
              ["value" => 2, "label" => "BroImbaLurker"]
            ];
        } else {
            $result = [
                ["value" => 2, "label" => "BroImbaLurker"]
            ];
        }
        echo json_encode($result);
    }

    /**
     * @return TwitchKraken
     * @throws \InvalidArgumentException
     */
    private function getTwitchService()
    {
        return $this->getContainer()->offsetGet('twitch');
    }

    public function form()
    {
        $this->response->setContent($this->twig->render('form.html.twig', array()));
    }
}