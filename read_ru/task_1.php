<?php
/**
 * Тестовое задание на собеседование read_ru
 *
 * Пожалуйста, разработайте класс для "перемешивания" предложения.
 * Задание:
 * Символ | является разделителем слов-вариантов. Например:
 * "{Пожалуйста|Просто} сделайте так, чтобы это {удивительное|крутое|простое} тестовое предложение {изменялось {быстро|мгновенно} случайным образом|изменялось каждый раз}."
 * На выходе должно получаться:
 * "Просто сделайте так, чтобы это удивительное тестовое предложение изменялось каждый раз."
 * или
 * "Просто сделайте так, чтобы это удивительное тестовое предложение изменялось мгновенно случайным образом".
 */

class sentence {
    /**
     * Delimeter for sentence
     *
     * @var string
     */
    protected $delimeter = "|";

    /**
     * Process sentence to replace data in {}
     *
     * @param string $sentence
     * @return string
     */
    public function process($sentence){
        $i = 0;
        while(preg_match("/(\{[^\{]+\})/U", $sentence, $aMatches)){
            $sReplacement = $this->get_replacement($aMatches[0]);
            $sentence = str_replace($aMatches[0], $sReplacement, $sentence);
            if (++$i > 10) break;
        }
        return (str) $sentence;
    }

    /**
     * Get replacement string
     *
     * @param string $str
     * @return string
     */
    protected function get_replacement($str){
        $sVariants = trim($str, "{}");
        $aVariants = explode($this->delimeter, $sVariants);
        $iIndx = array_rand($aVariants);
        return (str) $aVariants[$iIndx];
    }

}

$str = "{Пожалуйста|Просто} сделайте так, чтобы это {удивительное|крутое|простое} тестовое предложение {изменялось {быстро|мгновенно} случайным образом|изменялось каждый раз}.";
$sentence = new Sentence();
echo $sentence->process($str);