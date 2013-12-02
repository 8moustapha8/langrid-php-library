<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/15
 * Time: 15:40
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(__FILE__).'/ServiceClient.interface.php';
require_once dirname(__FILE__).'/../commons/Language.php';

interface NamedEntityTaggingClient extends ServiceClient {

    /*
     * @param lang: �Ώی���
     * @param text: �^�O�t�����s��������
     * @return array �^�O�t������
     */
    public function tag(Language $language, /*String*/ $text);
    
    
     /*
     * @return Array<String> �Ή�����
     */
    public function getSupportedLanguages();
}