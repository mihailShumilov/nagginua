<?php

/**
 * @class Document_Hash
 * Base class for documents hashing
 * @author Stanislav Perederiy
 */
class DocumentHash
{
    /// Content of the hashing document
    public $_doc_content = null;
    /// Document charset
    private $_charset = null;
    /// Tokens array
    public $_tokens = array();
    /// CRC32 hashes array
    private $_crc32 = array();
    /// Document length in sententences or words (this is not real length, it can't be greater than max_lenght)
    public $length = null;
    /// Document MD5
    public $docMD5 = null;

    public function __construct($doc_content, $charset = "UTF-8")
    {
        $this->_doc_content = $doc_content;
        $this->_charset     = $charset;

        // Prepare document for hashing
        $this->_prepare();

        // As we'll need MD5 of doc each time we use this class it makes sense to create it here
        $this->docMD5 = md5($this->_doc_content);
    }

    private function _prepare()
    {
        $this->_genericReplacements()
            ->_splitToTokens();
    }

    private function _makeCrc32array()
    {
        $this->_crc32 = array();
        foreach ($this->_tokens as $token) {
            $this->_crc32[] = crc32($token);
        }
        return $this;
    }

    public function getCrc32array()
    {
        if (count($this->_crc32) == 0) {
            $this->_makeCrc32array();
        }
        return $this->_crc32;
    }

    private function _splitToTokens()
    {
        $content = $this->_doc_content;
        $tmp     = array();
        $tmp2    = array();
        $slength = array();

        $content = str_replace(".", " ", $content);
        $tmp     = explode(" ", $content);
        foreach ($tmp as $word) {
            // let's count only words with more then 4 chars
            if (mb_strlen($word, $this->_charset) > 3) {
                $tmp2[$word]    = $word;
                $slength[$word] = strlen($word);
            }
        }

        array_multisort($slength, SORT_DESC, $tmp2, SORT_ASC);
        $count = count($slength);
        // Save only top15 (by length) sentences/words
        for ($i = 0; $i < $count && $i < 15; $i++) {
            $this->_tokens[] = current($tmp2);
            next($tmp2);
        }

        $this->length = count($this->_tokens);
        return $this;
    }

    private function _genericReplacements()
    {
        $this->_doc_content = strip_tags($this->_doc_content);
        $this->_doc_content = ltrim(rtrim($this->_doc_content));
        $this->_doc_content = mb_strtolower($this->_doc_content, $this->_charset);

        // Remove dots between chars (for things like urls)
        $this->_doc_content = $this->_my_preg_replace("/([a-z]{1})[\.]+([a-z]{1})/", "$1$2", $this->_doc_content);
        // ? Remove all html entities
        // $this->_doc_content = $this->_my_preg_replace("/&[#|a-z|0-9]+;/", " ", $this->_doc_content);
        // Decode all html entities
        $this->_doc_content = html_entity_decode($this->_doc_content, ENT_COMPAT, $this->_charset);
        // Replace multiple spaces chars with just one space
        $this->_doc_content = $this->_my_preg_replace("/[\s|\t|\n|\r]+/", " ", $this->_doc_content);
        // Remove dots, dashes and spaces between digits
        $this->_doc_content = $this->_my_preg_replace("/([0-9]{1})[\.|\s|\-]+([0-9]{1})/", "$1$2", $this->_doc_content);
        // Remove spaces after sentences and replace multiple dots with just one dot
        $this->_doc_content = $this->_my_preg_replace("/[\.]+ /", ".", $this->_doc_content);
        // The same for sentences ending with question marks
        $this->_doc_content = $this->_my_preg_replace("/[\?]+ /", ".", $this->_doc_content);
        // The same for "!"
        $this->_doc_content = $this->_my_preg_replace("/[\!]+ /", ".", $this->_doc_content);
        // Remove all non-alphanumeric characters except for spaces and dots
//        $this->_doc_content = $this->_my_preg_replace("/[^a-z|&#1072;-&#1103;|^\.|^\d|^\s|^@]+/i", "", $this->_doc_content);

        return $this;
    }

    /**
     * Wrapper for preg_replace. For correct support unicode and non-unicode charsets
     * @return: string
     **/
    private function _my_preg_replace($regex, $replace, $subject)
    {
        $u = "";
        if ($this->_charset == "UTF-8") {
            $u = "u";
        }
        return preg_replace($regex . $u, $replace, $subject);
    }

}
