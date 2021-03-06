<?php
/**
 * 项目选择
 * @param $value 选中值
 */
function proselect($value=1,$name=code) {
    $html = '<select name="'.$name.'" class="form-control">';
    $m =M('project');
    $where=array("testgp"=>$_SESSION['testgp']);
    $cats = $m->where($where)->order("end desc")->select();
    foreach($cats as $v) {
        $selected = ($v['id']==$value) ? "selected" : "";
        $html .= '<option '.$selected.' value="'.$v['id'].'">'.$v['code'].'</option>';
    }
    $html .='<select>';
    return $html;
}

/**
 * 根据stagetesterid获取列队信息
 */
function getSTester($stagetesterid){
    if ($stagetesterid){
        $m=M('tp_stagetester');
        $data=$m->find($stagetesterid);
        $str=$data['stage']."【".$data['state']."】";
        return $str;
    }else {
        return ;
    }
}




/**
 * 根据pathid获取功能列表
 */
function getFunces($pathid){
    $where['pathid']=$pathid;    
        $m=M('tp_func');
        $arr=$m->where($where)->select();
        foreach ($arr as $ar){
        $str.='<li class="list-group-item"><b>'
                . $ar['sn']."</b>-".$ar['func']."【".$ar['state']."】<span class='badge'>".getProNo($ar['fproid'])         
                .'</span></li>';
            }
        if ($arr){
            return $str;
        }else {
            return '无功能点';
        }
}


/**
 * 根据exesceneid获取执行场景功能信息
 */
function getESceneFunc($exesceneid){

    $m=D('tp_exefunc');
    $where['exesceneid']=$exesceneid;
    $arr=$m->where($where)->order('sn,id')->select();
    foreach ($arr as $ar){
        $str.='<li class="list-group-item">'
            .$ar['sn'].".".$ar['func'].":".$ar['remarks']
            ."（".$ar['casemain']."，<b>预期：</b>".$ar['caseexpected']."）"
            .$ar['remark'].'<span class="label label-default">'.$ar['updatetime']
            .'</span><span class="badge">'.$ar['result'].'</span>'
            .'</li>';
    }
    return $str;
}




