<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/22
 * Time: 16:18
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(__FILE__).'/ServiceClientImpl.php';
require_once dirname(__FILE__).'/../TextSummarizationClient.interface.php';

class TextSummarizationClientImpl extends ServiceClientImpl implements TextSummarizationClient
{
    public function summarize(Language $language, /*String*/ $text)
    {
        return $this->invoke(__FUNCTION__ ,array(
            'language' => $language,
            'text' => $text
        ));
    }
    
    public function getSupportedLanguages()
    {
        return $this->invoke(__FUNCTION__);
    }
}
