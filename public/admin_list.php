<?php  // admin_list.php
//
require_once('init_admin_auth.php');
// DB�ւ̐ڑ�
$dbh = db_connect($config);
// sort�p�z���C�g���X�g
$sort_list = [
    'id' => 'id',
    'id_d' => 'id DESC',
    // XXXXXX �ǉ�����
];
// �\�[�g���e�̔c��
$sort_wk = (string)@$_GET['sort'];
if (isset($sort_list[$sort_wk])) {
    $sort = $sort_list[$sort_wk];
} else {
    $sort = 'created_at DESC';
}
// �v���y�A�h�X�e�[�g�����g�̍쐬
$sql = 'SELECT * FROM inquiry ORDER BY ' . $sort .' LIMIT 0, 20;';
$pre = $dbh->prepare($sql);
// �l���o�C���h
// XXX �����(��U)�Ȃ�
// SQL�̎��s
$r = $pre->execute();
//�f�[�^���擾
$data = $pre->fetchAll();
$smarty_obj->assign('data', $data);
// �o��
$tmp_filename = 'admin_list.tpl';
require_once('./fin.php');
