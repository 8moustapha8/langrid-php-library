<?php

require_once('SOAP/Type/dateTime.php');

require_once (dirname(__FILE__) . '/../MultiLanguageStudio.php');
require_once (dirname(__FILE__) . '/../commons/Translation.php');
require_once (dirname(__FILE__) . '/../commons/SOAP/TranslationSOAP.php');

class ParallelTextSOAPServer
{
    private $server;

    public function __construct($serviceId)
    {

        require_once('SOAP/Server.php');
        header("Content-type: text/xml; charset=UTF-8");
        error_log("start soap server....");
        $this->server = new SOAP_Server();
        $this->server->addObjectMap(
            new ParallelTextService($serviceId)
            , 'http://paralleltext.ws_1_2.wrapper.langrid.nict.go.jp'
        );
        error_log("started");
        error_log(file_get_contents("php://input"));
    }

    public function  service($request)
    {
        return $this->server->service($request);
    }

}

class ParallelTextService
{
    private $dictionaryName;

    public function __construct($dictionaryName)
    {
        $this->dictionaryName = $dictionaryName;

        $this->__dispatch_map = array();
        // search
        $this->__dispatch_map['search'] = array(
            'in' => array(
                'sourceLang' => 'string'
            , 'targetLang' => 'string'
            , 'source' => 'string'
            , 'matchingMethod' => 'string'
            )
        , 'out' => array(
                'searchReturn' => '{urn:ParallelText}paralleltextArray')
        );
        // for exception defines
        $this->__typedef['stringArray'] = array(
            array('item' => 'string')
        );
        $this->__typedef['ParallelText'] = array(
            'source' => 'string'
        , 'target' => 'string'
        );
        $this->__typedef['paralleltextArray'] = array(
            array('item' => '{urn:ParallelText}ParallelText')
        );
    }


    public function search($headLang, $targetLang, $headWord, $matchingMethod)
    {

        error_log('search dic id=' . $this->dictionaryName);
        error_log('search lang=' . $headLang);
        error_log('search word=' . $headWord);

        $dictionary = Dictionary::find($this->dictionaryName);

        $translations = $dictionary->search($headLang, $targetLang, $headWord, $matchingMethod);

        $soap_translations = array();
        foreach($translations as $translation){
            array_push($soap_translations, new SOAP_Value('searchReturn', 'searchReturn', new TranslationSOAP($translation->getHeadWord(), $translation->getTargetWords())));
        }

        $result = new SOAP_Value('searchReturn', 'searchReturn', $soap_translations);

        return $result;
    }
}

