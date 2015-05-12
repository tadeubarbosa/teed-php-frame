<?php

	return [

		['@setContent(\'*\')',  String::php('Engine::setContent(\'$2\', function(){') ],

		['@endcontent',  String::php('} );') ],

		['@getContent(\'*\')',  String::php('Engine::getContent(\'$2\')') ],

		//

		['@template(*)', String::php('Engine::setTemplate($2)') ],

		//

		['@utf8( *, * )', String::php('if(is_string($3)){return utf8_encode($3);}elseif(is_object($3)){foreach($3 as $aKey => $aValue){$3->$aKey=utf8_encode($aValue);}}elseif(is_array($3)){foreach($3 as $aKey => $aValue){$3[\'$aKey\']=utf8_encode($aValue);}} $2=$3;') ],

		['@utf8(*)', String::php('if(is_string($2)){return utf8_encode($2);}elseif(is_object($2)){foreach($2 as $aKey => $aValue){$2->$aKey=utf8_encode($aValue);}}elseif(is_array($2)){foreach($2 as $aKey => $aValue){$2[\'$aKey\']=utf8_encode($aValue);}}') ],

		//

		['@objectUtf8( *, * )', String::php('$2=(object)$3;foreach($2 as $aKey=>$aValue){$2->$aKey=utf8_encode($aValue);}') ],

		['@objectUtf8(*)', String::php('$2=(object)$2') ],

		//

		['@arrayUtf8( *, * )', String::php('foreach($2 as $aKey=>$aValue){$2[\'$aKey\']=utf8_encode($aValue);}') ],

		//

		['@object( *, * )', String::php('$2 = (object) $3') ],

		['@object(*)', String::php('$2 = (object) $2') ],

		//

		['@array(*)', String::php('$2 = (array) $2') ],

		//

		['@base(*)', String::php('echo App::getBase($2)') ],

		['@image(*)', String::php('echo App::getImageDir($2)') ],

		['@script(*)', String::php('echo App::getScriptDir($2)') ],

		['@link(*)', String::php('echo App::getBase($2)') ],

		//

		['@include(*)', String::php('Engine::includeFile( App::getViewsDir() . $2 )') ],

		['@includePartial(*)', String::php('Engine::includePartial($2)') ],

		//

		['@if(*) * )', String::php('if($2) $3 ):') ],

		['@if(*) )', String::php('if($2) ):') ],

		['@if(*)', String::php('if($2):') ],

		['@elseif(*) )', String::php('elseif($2) ):') ],

		['@elseif(*)', String::php('elseif($2):') ],

		['@else', String::php('else:') ],

		['@endif', String::php('endif;') ],

		//

		['@foreach(*) as * )', String::php('foreach($2) as $3 ):') ],

		['@foreach(*) )', String::php('foreach($2) ):') ],

		['@foreach(*)', String::php('foreach($2):') ],

		['@endforeach', String::php('endforeach;') ],

		//

		['@for(*) )', String::php('for($2) ):') ],

		['@for(*)', String::php('for($2):') ],

		['@endfor', String::php('endfor;') ],

		//

		['@while(*) )', String::php('while($2) ):') ],

		['@while(*)', String::php('while($2):') ],

		['@endwhile', String::php('endwhile;') ],

		//

		['{{{ * }}}', String::php('$2;') ],

		['{{ * }}', String::php('echo $2;') ],

	];