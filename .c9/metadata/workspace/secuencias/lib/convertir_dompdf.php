{"filter":false,"title":"convertir_dompdf.php","tooltip":"/secuencias/lib/convertir_dompdf.php","ace":{"folds":[],"scrolltop":0,"scrollleft":0,"selection":{"start":{"row":12,"column":1},"end":{"row":12,"column":1},"isBackwards":false},"options":{"guessTabSize":true,"useWrapMode":false,"wrapToView":true},"firstLineState":{"row":82,"mode":"ace/mode/php"}},"hash":"0e438ff116fee5683d60a1dae5d23994209f3dda","undoManager":{"mark":52,"position":52,"stack":[[{"start":{"row":0,"column":6},"end":{"row":2,"column":5},"action":"remove","lines":["ob_start();?>","Texto","<?php"],"id":2}],[{"start":{"row":5,"column":0},"end":{"row":6,"column":0},"action":"insert","lines":["",""],"id":3}],[{"start":{"row":5,"column":0},"end":{"row":5,"column":1},"action":"insert","lines":["/"],"id":4}],[{"start":{"row":5,"column":1},"end":{"row":5,"column":2},"action":"insert","lines":["*"],"id":5}],[{"start":{"row":14,"column":8},"end":{"row":15,"column":0},"action":"insert","lines":["",""],"id":44}],[{"start":{"row":15,"column":0},"end":{"row":26,"column":1},"action":"insert","lines":["if (!isset($print)) $print=true;","if ($print){","$html_dom = ob_get_clean();","require_once(__DIR__.\"/dompdf/autoload.inc.php\");","use Dompdf\\Dompdf;","$dompdf = new Dompdf();","$dompdf->load_html($html_dom);","$dompdf->set_paper($tamano_dom,$orientacion_dom);//Esta línea es para hacer la página del PDF más grande //landscape/portrait","$dompdf->render();","$dompdf->stream(\"$nombre_dom.pdf\", array(\"Attachment\" => $adjunto_dom));","exit(0);","}"],"id":45}],[{"start":{"row":5,"column":1},"end":{"row":5,"column":2},"action":"remove","lines":["*"],"id":46}],[{"start":{"row":5,"column":0},"end":{"row":5,"column":1},"action":"remove","lines":["/"],"id":47}],[{"start":{"row":5,"column":0},"end":{"row":6,"column":12},"action":"insert","lines":["if (!isset($print)) $print=true;","if ($print){"],"id":48}],[{"start":{"row":16,"column":0},"end":{"row":26,"column":8},"action":"remove","lines":["if (!isset($print)) $print=true;","if ($print){","$html_dom = ob_get_clean();","require_once(__DIR__.\"/dompdf/autoload.inc.php\");","use Dompdf\\Dompdf;","$dompdf = new Dompdf();","$dompdf->load_html($html_dom);","$dompdf->set_paper($tamano_dom,$orientacion_dom);//Esta línea es para hacer la página del PDF más grande //landscape/portrait","$dompdf->render();","$dompdf->stream(\"$nombre_dom.pdf\", array(\"Attachment\" => $adjunto_dom));","exit(0);"],"id":49}],[{"start":{"row":15,"column":8},"end":{"row":16,"column":0},"action":"remove","lines":["",""],"id":50}],[{"start":{"row":6,"column":10},"end":{"row":6,"column":11},"action":"insert","lines":["="],"id":51}],[{"start":{"row":6,"column":11},"end":{"row":6,"column":12},"action":"insert","lines":["="],"id":52}],[{"start":{"row":6,"column":12},"end":{"row":6,"column":13},"action":"insert","lines":["t"],"id":53}],[{"start":{"row":6,"column":13},"end":{"row":6,"column":14},"action":"insert","lines":["r"],"id":54}],[{"start":{"row":6,"column":14},"end":{"row":6,"column":15},"action":"insert","lines":["u"],"id":55}],[{"start":{"row":6,"column":15},"end":{"row":6,"column":16},"action":"insert","lines":["e"],"id":56}],[{"start":{"row":8,"column":0},"end":{"row":10,"column":0},"action":"remove","lines":["require_once(__DIR__.\"/dompdf/autoload.inc.php\");","use Dompdf\\Dompdf;",""],"id":57},{"start":{"row":7,"column":0},"end":{"row":9,"column":0},"action":"insert","lines":["require_once(__DIR__.\"/dompdf/autoload.inc.php\");","use Dompdf\\Dompdf;",""]}],[{"start":{"row":7,"column":0},"end":{"row":9,"column":0},"action":"remove","lines":["require_once(__DIR__.\"/dompdf/autoload.inc.php\");","use Dompdf\\Dompdf;",""],"id":58},{"start":{"row":6,"column":0},"end":{"row":8,"column":0},"action":"insert","lines":["require_once(__DIR__.\"/dompdf/autoload.inc.php\");","use Dompdf\\Dompdf;",""]}],[{"start":{"row":15,"column":8},"end":{"row":16,"column":1},"action":"remove","lines":["","}"],"id":59},{"start":{"row":15,"column":0},"end":{"row":16,"column":0},"action":"insert","lines":["}",""]}],[{"start":{"row":15,"column":0},"end":{"row":16,"column":0},"action":"remove","lines":["}",""],"id":60},{"start":{"row":14,"column":0},"end":{"row":15,"column":0},"action":"insert","lines":["}",""]}],[{"start":{"row":14,"column":0},"end":{"row":15,"column":0},"action":"remove","lines":["}",""],"id":61},{"start":{"row":13,"column":0},"end":{"row":14,"column":0},"action":"insert","lines":["}",""]}],[{"start":{"row":13,"column":0},"end":{"row":14,"column":0},"action":"remove","lines":["}",""],"id":62},{"start":{"row":12,"column":0},"end":{"row":13,"column":0},"action":"insert","lines":["}",""]}],[{"start":{"row":12,"column":0},"end":{"row":13,"column":0},"action":"remove","lines":["}",""],"id":63},{"start":{"row":11,"column":0},"end":{"row":12,"column":0},"action":"insert","lines":["}",""]}],[{"start":{"row":11,"column":0},"end":{"row":12,"column":0},"action":"remove","lines":["}",""],"id":64},{"start":{"row":10,"column":0},"end":{"row":11,"column":0},"action":"insert","lines":["}",""]}],[{"start":{"row":10,"column":0},"end":{"row":11,"column":0},"action":"remove","lines":["}",""],"id":65},{"start":{"row":9,"column":0},"end":{"row":10,"column":0},"action":"insert","lines":["}",""]}],[{"start":{"row":9,"column":0},"end":{"row":11,"column":0},"action":"insert","lines":["","    ",""],"id":66}],[{"start":{"row":9,"column":0},"end":{"row":10,"column":0},"action":"insert","lines":["",""],"id":67}],[{"start":{"row":10,"column":0},"end":{"row":11,"column":4},"action":"remove","lines":["","    "],"id":68}],[{"start":{"row":10,"column":0},"end":{"row":10,"column":1},"action":"insert","lines":["e"],"id":69}],[{"start":{"row":10,"column":1},"end":{"row":10,"column":2},"action":"insert","lines":["x"],"id":70}],[{"start":{"row":10,"column":2},"end":{"row":10,"column":3},"action":"insert","lines":["i"],"id":71}],[{"start":{"row":10,"column":3},"end":{"row":10,"column":4},"action":"insert","lines":["t"],"id":72}],[{"start":{"row":10,"column":4},"end":{"row":10,"column":6},"action":"insert","lines":["()"],"id":73}],[{"start":{"row":10,"column":6},"end":{"row":10,"column":7},"action":"insert","lines":[";"],"id":74}],[{"start":{"row":8,"column":12},"end":{"row":8,"column":16},"action":"remove","lines":["true"],"id":75},{"start":{"row":8,"column":12},"end":{"row":8,"column":13},"action":"insert","lines":["f"]}],[{"start":{"row":8,"column":13},"end":{"row":8,"column":14},"action":"insert","lines":["a"],"id":76}],[{"start":{"row":8,"column":14},"end":{"row":8,"column":15},"action":"insert","lines":["l"],"id":77}],[{"start":{"row":8,"column":15},"end":{"row":8,"column":16},"action":"insert","lines":["s"],"id":78}],[{"start":{"row":8,"column":16},"end":{"row":8,"column":17},"action":"insert","lines":["e"],"id":79}],[{"start":{"row":9,"column":0},"end":{"row":9,"column":1},"action":"insert","lines":["e"],"id":80}],[{"start":{"row":9,"column":1},"end":{"row":9,"column":2},"action":"insert","lines":["c"],"id":81}],[{"start":{"row":9,"column":2},"end":{"row":9,"column":3},"action":"insert","lines":["h"],"id":82}],[{"start":{"row":9,"column":3},"end":{"row":9,"column":4},"action":"insert","lines":["o"],"id":83}],[{"start":{"row":9,"column":4},"end":{"row":9,"column":5},"action":"insert","lines":[" "],"id":84}],[{"start":{"row":12,"column":0},"end":{"row":13,"column":0},"action":"remove","lines":["$html_dom = ob_get_clean();",""],"id":85},{"start":{"row":11,"column":0},"end":{"row":12,"column":0},"action":"insert","lines":["$html_dom = ob_get_clean();",""]}],[{"start":{"row":11,"column":0},"end":{"row":12,"column":0},"action":"remove","lines":["$html_dom = ob_get_clean();",""],"id":86},{"start":{"row":10,"column":0},"end":{"row":11,"column":0},"action":"insert","lines":["$html_dom = ob_get_clean();",""]}],[{"start":{"row":10,"column":0},"end":{"row":11,"column":0},"action":"remove","lines":["$html_dom = ob_get_clean();",""],"id":87},{"start":{"row":9,"column":0},"end":{"row":10,"column":0},"action":"insert","lines":["$html_dom = ob_get_clean();",""]}],[{"start":{"row":9,"column":0},"end":{"row":10,"column":0},"action":"remove","lines":["$html_dom = ob_get_clean();",""],"id":88},{"start":{"row":8,"column":0},"end":{"row":9,"column":0},"action":"insert","lines":["$html_dom = ob_get_clean();",""]}],[{"start":{"row":8,"column":0},"end":{"row":9,"column":0},"action":"remove","lines":["$html_dom = ob_get_clean();",""],"id":89},{"start":{"row":7,"column":0},"end":{"row":8,"column":0},"action":"insert","lines":["$html_dom = ob_get_clean();",""]}],[{"start":{"row":7,"column":0},"end":{"row":8,"column":0},"action":"remove","lines":["$html_dom = ob_get_clean();",""],"id":90},{"start":{"row":8,"column":0},"end":{"row":9,"column":0},"action":"insert","lines":["$html_dom = ob_get_clean();",""]}],[{"start":{"row":10,"column":5},"end":{"row":10,"column":14},"action":"insert","lines":["$html_dom"],"id":91}],[{"start":{"row":10,"column":14},"end":{"row":10,"column":15},"action":"insert","lines":[";"],"id":92}]]},"timestamp":1505868465644}