<?php

class Neo_View_Helper_WidgetTwitter extends Zend_View_Helper_Abstract{

    public function widgetTwitter()
    {
        return " <script type='text/javascript' src='http://widgets.twimg.com/j/2/widget.js'></script>
            <script type='text/javascript'>
                new TWTR.Widget({
                  version: 2,
                  type: 'profile',
                  rpp: 4,
                  interval: 3000,
                  width: 200,
                  height: 200,
                  theme: {
                    shell: {
                      background: '#333333',
                      color: '#ffffff'
                    },
                    tweets: {
                      background: '#000000',
                      color: '#ffffff',
                      links: '#4aed05'
                    }
                  },
                  features: {
                    scrollbar: false,
                    loop: true,
                    live: true,
                    hashtags: true,
                    timestamp: true,
                    avatars: false,
                    behavior: 'default'
                  }
                }).render().setUser('vpuaoficial').start();
                </script>";
    }
}