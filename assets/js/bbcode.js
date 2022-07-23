const maxNestedLevel = 15;

function html2bbcode(s) {
    const recursiveTags = [
        {
            pattern: /<span style="([\w-]+): ?([\w#-]+); ?([\w-]+): ?([\w#-]+);?">([\s\S]*?)<\/span>/gi,
            replace: '<span style="$1: $2"><span style="$3: $4">$5</span></span>',
        },
        {
            pattern: /<span style="color: ?([\w#-]+);?">([\s\S]*?)<\/span>/gi,
            replace: '[color=$1]$2[/color]',
        },
        {
            pattern: /<font.*?color="(.*?)".*?>([\s\S]*?)<\/font>/gi,
            replace: '[color=$1]$2[/color]',
        },
        {
            pattern: /<span style="text-decoration: ?underline;?">([\s\S]*?)<\/span>/gi,
            replace: '[u]$1[/u]',
        },
        {
            pattern: /<ul>([\s\S]*?)<\/ul>/gi,
            replace: '[list]$1[/list]',
        },
        {
            pattern: /<ol>([\s\S]*?)<\/ol>/gi,
            replace: '[olist]$1[/olist]',
        },
        {
            pattern: /<li>([\s\S]*?)<\/li>/gi,
            replace: '[*]$1[/*]',
        }
    ];

    recursiveTags.forEach(function (value) {
        let i = 0;

        while (value.pattern.test(s) && i++ < maxNestedLevel) {
            s = s.replace(value.pattern, value.replace);
        }
    });

    return s.replace(/<font>([\s\S]*?)<\/font>/gi, '$1')
        .replace(/<span>([\s\S]*?)<\/span>/gi, '$1')
        .replace(/<b>([\s\S]*?)<\/b>/gi, '[b]$1[/b]')
        .replace(/<strong>([\s\S]*?)<\/strong>/gi, '[b]$1[/b]')
        .replace(/<i>([\s\S]*?)<\/i>/gi, '[i]$1[/i]')
        .replace(/<em>([\s\S]*?)<\/em>/gi, '[i]$1[/i]')
        .replace(/<u>([\s\S]*?)<\/u>/gi, '[u]$1[/u]')
        .replace(/<span style="text-decoration: ?line-through;?">([\s\S]*?)<\/span>/gi, '[s]$1[/s]')
        .replace(/<a.*?href="(.*?)".*?>([\s\S]*?)<\/a>/gi, '[url=$1]$2[/url]')
        .replace(/<img.*?src="(.*?)".*?alt="(.*?)".*?\/>/gi, '[img=$2]$1[/img]')
        .replace(/<img.*?src="(.*?)".*?\/>/gi, '[img]$1[/img]')
        .replace(/<center>([\s\S]*?)<\/center>/gi, '[center]$1[/center]')
        .replace(/<p style="text-align: ?left;?">([\s\S]*?)<\/p>/gi, '$1')
        .replace(/<p style="text-align: ?center;?">([\s\S]*?)<\/p>/gi, '[center]$1[/center]')
        .replace(/<p style="text-align: ?right;?">([\s\S]*?)<\/p>/gi, '[right]$1[/right]')
        .replace(/<blockquote>([\s\S]*?)<\/blockquote>/gi, '[quote]$1[/quote]')
        .replace(/<pre class="language-(.*?)"><code>([\s\S]*?)<\/code><\/pre>/gi, '[code=$1]$2[/code]')
        .replace(/<pre><code>([\s\S]*?)<\/code><\/pre>/gi, '[code]$1[/code]')
        .replace(/<blockquote>([\s\S]*?)<\/blockquote>/gi, '[quote]$1[/quote]')
        .replace(/<h1>([\s\S]*?)<\/h1>/gi, '[h1]$1[/h1]')
        .replace(/<h2>([\s\S]*?)<\/h2>/gi, '[h2]$1[/h2]')
        .replace(/<h3>([\s\S]*?)<\/h3>/gi, '[h3]$1[/h3]')
        .replace(/<h4>([\s\S]*?)<\/h4>/gi, '[h4]$1[/h4]')
        .replace(/<h5>([\s\S]*?)<\/h5>/gi, '[h5]$1[/h5]')
        .replace(/<h6>([\s\S]*?)<\/h6>/gi, '[h6]$1[/h6]')
        .replace(/<p>([\s\S]*?)<\/p>/gi, '$1')
        .replace(/<br ?\/?>/gi, '\n')
        .replace(/&nbsp;?|\u00a0/gi, ' ')
        .replace(/&quot;?/gi, '"')
        .replace(/&lt;?/gi, '<')
        .replace(/&gt;?/gi, '>')
        .replace(/&amp;?/gi, '&');
}

function bbcode2html(s) {
    const recursiveTags = [
        {
            pattern: /\[list]\n?([\s\S]*?)\[\/list]\n?/gi,
            replace: '<ul>$1</ul>',
        },
        {
            pattern: /\[olist]\n?([\s\S]*?)\[\/olist]\n?/gi,
            replace: '<ol>$1</ol>',
        },
        {
            pattern: /\[\*]([\s\S]*?)\n?\[\/\*]\n?\n?/g,
            replace: '<li>$1</li>',
        },
        {
            pattern: /\[\*](.*?)\n/g,
            replace: '<li>$1</li>',
        },
        {
            pattern: /\[color=(#\w{3,6})]([\s\S]*?)\[\/color]/gi,
            replace: '<span style="color: $1">$2</span>',
        },
    ];

    recursiveTags.forEach(function (value) {
        let i = 0;

        while (value.pattern.test(s) && i++ < maxNestedLevel) {
            s = s.replace(value.pattern, value.replace);
        }
    });

    return s.replace(/\[b]([\s\S]*?)\[\/b]/gi, '<strong>$1</strong>')
        .replace(/\[i]([\s\S]*?)\[\/i]/gi, '<em>$1</em>')
        .replace(/\[u]([\s\S]*?)\[\/u]/gi, '<u>$1</u>')
        .replace(/\[s]([\s\S]*?)\[\/s]/gi, '<span style="text-decoration: line-through">$1</span>')
        .replace(/\[url]([\s\S]*?)\[\/url]/gi, '<a href="$1">$1</a>')
        .replace(/\[url=([^\]]+)]([\s\S]*?)\[\/url]/gi, '<a href="$1">$2</a>')
        .replace(/\[img=?]([\s\S]*?)\[\/img]/gi, '<img src="$1">')
        .replace(/\[img=([^\]]+)]([\s\S]*?)\[\/img]/gi, '<img src="$2" alt="$1">')
        .replace(/\[h1]([\s\S]*?)\[\/h1]\n?/gi, '<h1>$1</h1>')
        .replace(/\[h2]([\s\S]*?)\[\/h2]\n?/gi, '<h2>$1</h2>')
        .replace(/\[h3]([\s\S]*?)\[\/h3]\n?/gi, '<h3>$1</h3>')
        .replace(/\[h4]([\s\S]*?)\[\/h4]\n?/gi, '<h4>$1</h4>')
        .replace(/\[h5]([\s\S]*?)\[\/h5]\n?/gi, '<h5>$1</h5>')
        .replace(/\[h6]([\s\S]*?)\[\/h6]\n?/gi, '<h6>$1</h6>')
        .replace(/\[code=?]\n?([\s\S]*?)\[\/code]\n?/gi, '<pre><code>$1</code></pre>')
        .replace(/\[code=(\w*?)]\n?([\s\S]*?)\[\/code]\n?/gi, '<pre class="language-$1"><code>$2</code></pre>')
        .replace(/\[quote]\n?([\s\S]*?)\[\/quote]\n?/gi, '<blockquote>$1</blockquote>')
        .replace(/\[center]([\s\S]*?)\[\/center]\n?/gi, '<p style="text-align: center">$1</p>')
        .replace(/\n/g, '<br>');
}

tinymce.PluginManager.add('azuriombbcode', function (editor) {
    editor.on('BeforeSetContent', (e) => {
        e.content = bbcode2html(e.content);
    });

    editor.on('PostProcess', (e) => {
        if (e.set) {
            e.content = bbcode2html(e.content);
        }

        if (e.get) {
            e.content = html2bbcode(e.content);
        }
    });
});
