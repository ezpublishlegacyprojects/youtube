<?php

class YoutubeTagSearch
{
    /*!
     Constructor
    */
    function YoutubeTagSearch()
    {
        $this->Operators = array( 'youtube_tag_search');
    }

    /*!
     Returns the operators in this class.
    */
    function &operatorList()
    {
        return $this->Operators;
    }

    /*!
     \return true to tell the template engine that the parameter list
    exists per operator type, this is needed for operator classes
    that have multiple operators.
    */
    function namedParameterPerOperator()
    {
        return true;
    }

    /*!
     The first operator has two parameters, the other has none.
     See eZTemplateOperator::namedParameterList()
    */
    function namedParameterList()
    {
        return array(                      
                      'youtube_tag_search' => array('dev_id' => array( 'type' => 'string',
                                                                     'required' => true,
                                                                     'default' => '' ),
                                                'tag' => array( 'type' => 'string',
                                                                     'required' => true,
                                                                     'default' => '' ),
                                                'per_page' => array( 'type' => 'string',
                                                                     'required' => true,
                                                                     'default' => '' )
                                            ) );
    }

    /*!
     Executes the needed operator(s).
     Checks operator names, and calls the appropriate functions.
    */
    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace,
                     &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        switch ( $operatorName )
        {
            case 'youtube_tag_search':
            {
                $operatorValue = $this->youtube_tag_search( $namedParameters['dev_id'], 
                                                        $namedParameters['tag'], 
                                                        $namedParameters['per_page']);
            } break;
        }
    }

function youtube_parse_xml($data) {
$xml_parser = xml_parser_create();

xml_parse_into_struct($xml_parser, $data, $vals, $index);
xml_parser_free($xml_parser);

  $videos_array = array();
  $video_array = null;
  foreach ($vals as $elem) {
    if ($elem['tag'] == 'VIDEO' && $elem['type'] == 'open') {
      $video_array = array();
    } else if ($elem['tag'] == 'VIDEO' && $elem['type'] == 'close') {
      if ($video_array != null) {
        $videos_array[$video_array['id']] = $video_array;
      }
      $video_array = null; 
    } else if ($elem['tag'] == 'ID') {
      $video_array['id'] = $elem['value'];
    } else if ($elem['tag'] == 'THUMBNAIL_URL') {
      $video_array['thumbnail_url'] = $elem['value'];
    } else if ($elem['tag'] == 'URL') {
      $video_array['url'] = $elem['value'];
    } else if ($elem['tag'] == 'DESCRIPTION') {
      $video_array['description'] = $elem['value'];
    } else if ($elem['tag'] == 'TITLE') {
      $video_array['title'] = $elem['value'];
    } else if ($elem['tag'] == 'TAGS') {
      $video_array['tags'] = $elem['value'];
    } else if ($elem['tag'] == 'UPLOAD_TIME') {
      $video_array['upload_time'] = $elem['value'];
    } else if ($elem['tag'] == 'COMMENT_COUNT') {
      $video_array['comment_count'] = $elem['value'];
    } else if ($elem['tag'] == 'VIEW_COUNT') {
      $video_array['view_count'] = $elem['value'];
    } else if ($elem['tag'] == 'RATING_AVG') {
      $video_array['rating_avg'] = $elem['value'];
    } else if ($elem['tag'] == 'RATING_COUNT') {
      $video_array['rating_count'] = $elem['value'];
    } else if ($elem['tag'] == 'LENGTH_SECONDS') {
      $video_array['length_seconds'] = $elem['value'];
    } else if ($elem['tag'] == 'AUTHOR') {
      $video_array['author'] = $elem['value'];
    } else {
      //print_r($elem);
    }
  }
  return $videos_array;
}


    function youtube_tag_search( $dev_id, $tag, $per_page  )
    { 
        $params = array(
	          'dev_id'	=> $dev_id,
	          'method'	=> 'youtube.videos.list_by_tag',
	          'tag'		=> $tag,
                  'per_page'	=> $per_page,
                  );

        $encoded_params = array();

        foreach ($params as $k => $v){
            $encoded_params[] = urlencode($k).'='.urlencode($v);
        }

        $url = "http://www.youtube.com/api2_rest?".implode('&', $encoded_params);

        $rsp = file_get_contents($url);

        $rsp_obj = $this->youtube_parse_xml($rsp);

        $result = '<ul>';

        foreach ($rsp_obj as $k => $v){

            $key = $k;
            $thumb_url = $rsp_obj[$key]['thumbnail_url'];
            $youtube_url = $rsp_obj[$key]['url'];
            $result .= '<li><a href="' . $youtube_url . '"><img src="' . $thumb_url . '" alt="' . $rsp_obj[$key]['title'] . '" title="' . $rsp_obj[$key]['title'] . '" /></a></li>';
        }
    $result .= '</ul>';

    return $result;
}

    /// \privatesection
    var $Operators;
}

?>