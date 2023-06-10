<?php

namespace VideoGamesRecords\DwhBundle\Traits\Top;

trait GetHtmlTopPlayerTrait
{
    /**
     * @param        $data
     * @param string $locale
     * @return string
     */
    private function getHtmlTopPlayer($data, string $locale = 'en'): string
    {
        $html = '';

        if (count($data['list']) > 0) {
            $html .= '<div class="article-top article-top__players">';
            for ($i = 0; $i <= 2; $i++) {
                if (array_key_exists($i, $data['list'])) {
                    $html .= sprintf(
                        '<a href="%s"><img src="https://backoffice.video-games-records.com/users/%d/avatar" alt="%s" class="article-top__player" /></a>',
                        '/' . $locale . '/' . $data['list'][$i]['player']->getUrl(),
                        $data['list'][$i]['player']->getId(),
                        $data['list'][$i]['player']->getPseudo()
                    );
                }
                if ($i == 0) {
                    $html .= '<br />';
                }
            }

            $html .= '<table class="article-top__table">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th scope="col"><abbr title="Rank">#</abbr></th>';
            $html .= '<th scope="col">Player</th>';
            $html .= '<th scope="col">Posts submitted</th>';
            $html .= '<th scope="col">Position change</th>';
            $html .= '</tr>';
            $html .= '</tr>';
            $html .= '<tbody>';

            foreach ($data['list'] as $row) {
                $html .= sprintf(
                    $this->getHtmLine(),
                    $row['rank'],
                    '/' . $locale . '/' . $row['player']->getUrl(),
                    (($row['player'] != null) ? $row['player']->getPseudo() : '???'),
                    $row['nb'],
                    $this->diff($row, count($data['list']))
                );
            }

            if ($data['nbTotalPost'] > $data['nbPostFromList']) {
                $html .= sprintf(
                    $this->getHtmlBottom1(),
                    count($data['list']) + 1,
                    $data['nb'],
                    $data['nbTotalPost'] - $data['nbPostFromList']
                );
            }
            $html .= sprintf($this->getHtmlBottom2(), $data['nbTotalPost']);
            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '</div>';
        }

        return $html;
    }
}
