<?php 
class Dictionary extends CI_Model
{
    function __construct()
    {
        $this->load->database();
    }
    public function GetKeyword($key = '')
    {
        if (!$key) {
            return '';
        }
        $lang=$this->UserModel->language();
        if(!$lang){
            $lang='ENGLISH';
        }
        $key=str_replace(' ','_',strtolower($key));
        $keyword=$this->Get_info->select('dictionary','KEYWORD ='.$this->db->escape($key));
        if(!$keyword){
            $langkey=$this->ConvertToEnglish($key);
            $this->Get_info->insert_data('dictionary',['KEYWORD'=>$key,'ENGLISH'=>$langkey]);
        }
        if($keyword && $keyword[0][$lang] && $keyword[0][$lang]!=''){
            $langkey=$keyword[0][$lang];
        }else{
            $langkey=$this->ConvertToEnglish($key);
            /* $this->Get_info->insert_data('dictionary',['KEYWORD'=>$key,'ENGLISH'=>$langkey]); */
        }
        return $langkey;
    }
    public function ConvertToEnglish($key)
    {
        $keyword=str_replace('_',' ',$key);
        return ucwords($keyword);
    }
}