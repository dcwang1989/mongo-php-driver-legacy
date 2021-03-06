--TEST--
MongoCursor::hint()
--SKIPIF--
<?php require_once "tests/utils/standalone.inc" ?>
--FILE--
<?php
require_once "tests/utils/server.inc";

function log_query($server, $query, $cursor_options) {
    var_dump($query['$hint']);
}

$ctx = stream_context_create(array('mongodb' => array('log_query' => 'log_query')));
$host = MongoShellServer::getStandaloneInfo();
$mc = new MongoClient($host, array(), array("context" => $ctx));

$c = $mc->selectCollection(dbname(), 'mongocursor-hint-001');
$c->find()->hint('x_1')->next();
$c->find()->hint(array('x' => 1))->next();
$c->find()->hint(new stdClass())->next();

?>
--EXPECTF--
string(3) "x_1"
array(1) {
  ["x"]=>
  int(1)
}
object(stdClass)#%d (0) {
}
