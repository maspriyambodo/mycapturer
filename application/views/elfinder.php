<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>File Manager</title>
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet"/>
        <link href="https://cdn.maspriyambodo.com/Metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" crossorigin="anonymous"/>
        <link href="https://cdn.maspriyambodo.com/Metronic/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" crossorigin="anonymous"/>
        <link href="https://cdn.maspriyambodo.com/Metronic/assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" crossorigin="anonymous"/>
        <link href="https://cdn.maspriyambodo.com/Metronic/assets/css/style.bundle.css" rel="stylesheet" type="text/css" crossorigin="anonymous"/>
        <link href="https://cdn.maspriyambodo.com/Metronic/assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" crossorigin="anonymous"/>
        <link href="https://cdn.maspriyambodo.com/Metronic/assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" crossorigin="anonymous"/>
        <link href="https://cdn.maspriyambodo.com/Metronic/assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" crossorigin="anonymous"/>
        <link href="https://cdn.maspriyambodo.com/Metronic/assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" crossorigin="anonymous"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" rel="stylesheet"/>
        <link href="<?php echo base_url('assets/images/systems/' . $this->bodo->Sys('favico')); ?>" rel="shortcut icon"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2" />
        <script src="//cdnjs.cloudflare.com/ajax/libs/require.js/2.3.2/require.min.js"></script>
        <script>
            define("elFinderConfig", {
                defaultOpts: {
                    url: "<?php echo $connector ?>",
                    commandsOptions: {
                        edit: { extraOptions: { creativeCloudApiKey: "", managerUrl: "" } },
                        quicklook: {
                            googleDocsMimes: [
                                "application/pdf",
                                "image/tiff",
                                "application/vnd.ms-office",
                                "application/msword",
                                "application/vnd.ms-word",
                                "application/vnd.ms-excel",
                                "application/vnd.ms-powerpoint",
                                "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                            ]
                        }
                    },
                    bootCallback: function (b, a) {
                        b.bind("init", function () {});
                        var c = document.title;
                        b.bind("open", function () {
                            var e = "",
                                d = b.cwd();
                            if (d) {
                                e = b.path(d.hash) || null;
                            }
                            document.title = e ? e + ":" + c : c;
                        }).bind("destroy", function () {
                            document.title = c;
                        });
                    }
                },
                managers: { elfinder: {} }
            });
            define("returnVoid", void 0);
            (function () {
                var e = "<?php echo elFinder::getApiFullVersion() ?>",
                    b = "3.2.1",
                    c = "1.12.1",
                    f = (function () {
                        var k = window.location.search,
                            i,
                            h,
                            j;
                        if (k && (h = k.match(/lang=([a-zA-Z_-]+)/))) {
                            i = h[1];
                        } else {
                            i = navigator.browserLanguage || navigator.language || navigator.userLanguage;
                        }
                        j = i.substr(0, 2);
                        if (j === "ja") {
                            j = "jp";
                        } else {
                            if (j === "pt") {
                                j = "pt_BR";
                            } else {
                                if (j === "ug") {
                                    j = "ug_CN";
                                } else {
                                    if (j === "zh") {
                                        j = i.substr(0, 5).toLowerCase() === "zh-tw" ? "zh_TW" : "zh_CN";
                                    }
                                }
                            }
                        }
                        return j;
                    })(),
                    g = function (j, i, h) {
                        j.prototype.loadCss("//cdnjs.cloudflare.com/ajax/libs/jqueryui/" + c + "/themes/smoothness/jquery-ui.css");
                        $(function () {
                            var l = { commandsOptions: { edit: { editors: Array.isArray(i) ? i : [] } } },
                                k = {};
                            if (h && h.managers) {
                                $.each(h.managers, function (o, n) {
                                    k = Object.assign(k, h.defaultOpts || {});
                                    try {
                                        n.commandsOptions.edit.editors = n.commandsOptions.edit.editors.concat(i || []);
                                    } catch (m) {
                                        Object.assign(n, l);
                                    }
                                    $("#" + o).elfinder($.extend(true, { lang: f }, k, n || {}), function (q, p) {
                                        q.bind("init", function () {
                                            delete q.options.rawStringDecoder;
                                            if (q.lang === "jp") {
                                                require(["encoding-japanese"], function (r) {
                                                    if (r.convert) {
                                                        q.options.rawStringDecoder = function (t) {
                                                            return r.convert(t, { to: "UNICODE", type: "string" });
                                                        };
                                                    }
                                                });
                                            }
                                        });
                                    });
                                });
                            } else {
                                alert('"elFinderConfig" object is wrong.');
                            }
                        });
                    },
                    d = function () {
                        require(["elfinder", "extras/editors.default", "elFinderConfig"], g, function (h) {
                            alert(h.message);
                        });
                    },
                    a = typeof window.addEventListener === "undefined" && typeof document.getElementsByClassName === "undefined";
                require.config({
                    baseUrl: "//cdnjs.cloudflare.com/ajax/libs/elfinder/" + e + "/js",
                    paths: {
                        jquery: "//cdnjs.cloudflare.com/ajax/libs/jquery/" + (a ? "1.12.4" : b) + "/jquery.min",
                        "jquery-ui": "//cdnjs.cloudflare.com/ajax/libs/jqueryui/" + c + "/jquery-ui.min",
                        elfinder: "elfinder.min",
                        "encoding-japanese": "//cdn.rawgit.com/polygonplanet/encoding.js/master/encoding.min"
                    },
                    waitSeconds: 10
                });
                d();
            })();
        </script>
    </head>
    <body>
        <div id="elfinder"></div>
    </body>
</html>
