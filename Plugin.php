<?php
/**
* 基于 Baidu MuPlayer Typecho 插件
* @package BaiduMuPlayer
* @author HyanCat <hyancat@live.cn>
* @link http://hyancat.com 流光不加少个人主页
* @version 0.0.3
*/
class MuPlayer_Plugin implements Typecho_Plugin_Interface
{
    /**
    * 激活插件方法,如果激活失败,直接抛出异常
    *
    * @access public
    * @return void
    * @throws Typecho_Plugin_Exception
    */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->header = array('MuPlayer_Plugin', 'addHeader');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('MuPlayer_Plugin', 'addFooter');
        return "BaiduMuPlayer插件成功启用，请在设置里添加歌曲";
    }

    /**
    * 禁用插件方法,如果禁用失败,直接抛出异常
    *
    * @static
    * @access public
    * @return void
    * @throws Typecho_Plugin_Exception
    */
    public static function deactivate(){}
    
    /**
    * 获取插件配置面板
    *
    * @access public
    * @param Typecho_Widget_Helper_Form $form 配置面板
    * @return void
    */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $addsong = new Typecho_Widget_Helper_Form_Element_Textarea('songlist',
            NULL, '',
            _t('<span style="font-size: 16px">添加歌曲</span><span>(每首歌曲占一行)</span>'),
            _t('<p>说明：<br>
                &nbsp;&nbsp;&nbsp;&nbsp;
                格式为： &nbsp;&nbsp; 歌曲名 &nbsp; + &nbsp; |（分隔符） &nbsp; + &nbsp; 歌曲链接 &nbsp;&nbsp; （注：不计空格，歌曲链接重复则忽略）<br>
                &nbsp;&nbsp;&nbsp;&nbsp;
                例如：&nbsp;&nbsp; 张三的歌 | http://www.abcdefg.com/music/123456.mp3
                </p>'));
        $form->addInput($addsong);
    }

    /**
    * 个人用户的配置面板
    *
    * @access public
    * @param Typecho_Widget_Helper_Form $form
    * @return void
    */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    

    /**
     * header中添加引入的css
     */
    public static function addHeader()
    {
        // if (Typecho_Widget::widget('Widget_Archive')->is('index')) {
            echo '<link rel="stylesheet" type="text/css" href="' . Helper::options()->pluginUrl . '/MuPlayer/css/player.css" />' . "\n";
        // }
    }

    /**
     * footer中添加引入的js
     */
    public static function addFooter()
    {
        // if (Typecho_Widget::widget('Widget_Archive')->is('index')) {
            echo '<script type="text/javascript" src="' . Helper::options()->pluginUrl . '/MuPlayer/lib/muplayer/player.min.js' . '"></script>' . "\n";
            echo '<script type="text/javascript" src="' . Helper::options()->pluginUrl . '/MuPlayer/js/player.js' . '"></script>' . "\n";
        // }
    }

    /**
    * 解析数据
    * @return array
    */
    private static function songs()
    {
        $options = Typecho_Widget::widget('Widget_Options');
        $songlist = $options->plugin('MuPlayer')->songlist;
        $songs_tmp = explode("\n", $songlist);
        $songs = array();
        foreach ($songs_tmp as $song_tmp) {
            $song_tmp = trim($song_tmp);
            $song_tmp = explode("|", $song_tmp);
            $song = array();
            $song['title'] = $song_tmp[0];
            $song['url'] = $song_tmp[1];
            $songs[$song['url']] = $song;
        }
        return $songs;
    }

    /**
     * 输出播放器，用于页面调用
     * @return [type] [description]
     */
    public static function player()
    {
        $options = Typecho_Widget::widget('Widget_Options');
        $songs = self::songs();
        
        echo "<ul id=\"playlist\" class=\"playlist\">";
        foreach ($songs as $song) {
            echo "<li data-link=" . $song['url'] . "><i class=\"play-btn\"></i>" . $song['title'] . "</li>";
        }
        echo "</ul>";
    }

}