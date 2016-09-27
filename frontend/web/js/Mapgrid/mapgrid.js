/*
 * Mapgrid.js 0.1 - JavaScript Mapgrid Library
 *
 * Copyright (c) 2011, Healer Kx healer_kx@163.com
 * Dual-licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 */

(function (w) {
    // the MapgridFactory creates Mapgrid instances
    var MapgridFactory = (function () {

        // store object constructor
        // a Mapgrid contains a store
        // the store has to know about the Mapgrid in order to trigger Mapgrid updates when datapoints get added
        var store = function store(hmap) {

            var _ = {
                // data is a two dimensional array
                // a datapoint gets saved as data[point-x-value][point-y-value]
                // the value at [point-x-value][point-y-value] is the occurrence of the datapoint
                data: [],
                // tight coupling of the Mapgrid object
                Mapgrid: hmap
            };
            // the max occurrence - the Mapgrids radial gradient alpha transition is based on it
            this.max = 1;

            this.get = function (key) {
                return _[key];
            };
            this.set = function (key, value) {
                _[key] = value;
            };
        };

        store.prototype = {
            // Just show static data, so this function maybe deprecated
            addDataPoint: function (x, y) {
                if (x < 0 || y < 0)
                    return;

                var me = this,
                    Mapgrid = me.get("Mapgrid"),
                    data = me.get("data");

                if (!data[x])
                    data[x] = [];

                if (!data[x][y])
                    data[x][y] = 0;

                // if count parameter is set increment by count otherwise by 1
                data[x][y] += (arguments.length < 3) ? 1 : arguments[2];

                me.set("data", data);
                // do we have a new maximum?
                if (me.max < data[x][y]) {
                    // max changed, we need to redraw all existing(lower) datapoints
                    Mapgrid.get("actx").clearRect(0, 0, Mapgrid.get("width"), Mapgrid.get("height"));
                    me.setDataSet({max: data[x][y], data: data}, true);
                    return;
                }
                Mapgrid.drawAlpha(x, y, data[x][y], true);
            },
            setDataSet: function (obj, internal) {
                var me = this,
                    Mapgrid = me.get("Mapgrid"),
                    data = [],
                    d = obj.data,
                    dlen = d.length;
                // clear the Mapgrid before the data set gets drawn
                Mapgrid.clear();
                this.max = obj.max; // TODO: Maybe no use.
                // if a legend is set, update it
                // console.log(Mapgrid.get("legend"));
                Mapgrid.get("legend") && Mapgrid.get("legend").update(obj.max);

                if (internal != null && internal) {
                    for (var one in d) {
                        // jump over undefined indexes
                        if (one === undefined)
                            continue;
                        for (var two in d[one]) {
                            if (two === undefined)
                                continue;
                            // if both indexes are defined, push the values into the array
                            Mapgrid.drawAlpha(one, two, d[one][two], false);
                        }
                    }
                } else {
                    while (dlen--) {
                        var point = d[dlen];
                        Mapgrid.drawAlpha(point.x, point.y, point.count, false);
                        if (!data[point.x])
                            data[point.x] = [];

                        if (!data[point.x][point.y])
                            data[point.x][point.y] = 0;

                        data[point.x][point.y] = point.count;
                    }
                }
                Mapgrid.colorize();
                this.set("data", d);
            },
            exportDataSet: function () {
                var me = this,
                    data = me.get("data"),
                    exportData = [];

                for (var one in data) {
                    // jump over undefined indexes
                    if (one === undefined)
                        continue;
                    for (var two in data[one]) {
                        if (two === undefined)
                            continue;
                        // if both indexes are defined, push the values into the array
                        exportData.push({x: parseInt(one, 10), y: parseInt(two, 10), count: data[one][two]});
                    }
                }

                return {max: me.max, data: exportData};
            },
            /*
             generateRandomDataSet: function(points){
             var Mapgrid = this.get("Mapgrid"),
             w = Mapgrid.get("width"),
             h = Mapgrid.get("height");
             var randomset = {},
             max = Math.floor(Math.random()*1000+1);
             randomset.max = max;
             var data = [];
             while(points--){
             data.push({x: Math.floor(Math.random()*w+1), y: Math.floor(Math.random()*h+1), count: Math.floor(Math.random()*max+1)});
             }
             randomset.data = data;
             this.setDataSet(randomset);
             }
             */
        };

        var legend = function legend(config) {
            this.config = config;

            var _ = {
                element: null,
                labelsEl: null,
                gradientCfg: null,
                ctx: null
            };
            this.get = function (key) {
                return _[key];
            };
            this.set = function (key, value) {
                _[key] = value;
            };
            this.init();
        };
        legend.prototype = {
            init: function () {
                var me = this,
                    config = me.config,
                    title = config.title || "Legend",
                    position = config.position,
                    offset = config.offset || 10,
                    gconfig = config.gradient,
                    labelsEl = document.createElement("ul"),
                    labelsHtml = "",
                    grad, element, gradient, positionCss = "";

                me.processGradientObject();

                // Positioning

                // top or bottom
                if (position.indexOf('t') > -1) {
                    positionCss += 'top:' + offset + 'px;';
                } else {
                    positionCss += 'bottom:' + offset + 'px;';
                }

                // left or right
                if (position.indexOf('l') > -1) {
                    positionCss += 'left:' + offset + 'px;';
                } else {
                    positionCss += 'right:' + offset + 'px;';
                }

                element = document.createElement("div");
                element.style.cssText = "border-radius:5px;position:absolute;" + positionCss + "font-family:Helvetica; width:256px;z-index:10000000000; background:rgba(255,255,255,1);padding:10px;border:1px solid black;margin:0;";
                element.innerHTML = "<h3 style='padding:0;margin:0;text-align:center;font-size:16px;'>" + title + "</h3>";
                // create gradient in canvas
                labelsEl.style.cssText = "position:relative;font-size:12px;display:block;list-style:none;list-style-type:none;margin:0;height:15px;";


                // create gradient element
                gradient = document.createElement("div");
                gradient.style.cssText = ["position:relative;display:block;width:256px;height:15px;border-bottom:1px solid black; background-image:url(", me.createGradientImage(), ");"].join("");

                element.appendChild(labelsEl);
                element.appendChild(gradient);

                me.set("element", element);
                me.set("labelsEl", labelsEl);

                me.update(1);
            },
            processGradientObject: function () {
                // create array and sort it
                var me = this,
                    gradientConfig = this.config.gradient,
                    gradientArr = [];

                for (var key in gradientConfig) {
                    if (gradientConfig.hasOwnProperty(key)) {
                        gradientArr.push({stop: key, value: gradientConfig[key]});
                    }
                }
                gradientArr.sort(function (a, b) {
                    return (a.stop - b.stop);
                });
                gradientArr.unshift({stop: 0, value: 'rgba(0,0,0,0)'});

                me.set("gradientArr", gradientArr);
            },
            createGradientImage: function () {
                var me = this,
                    gradArr = me.get("gradientArr"),
                    length = gradArr.length,
                    canvas = document.createElement("canvas"),
                    ctx = canvas.getContext("2d"),
                    grad;
                // the gradient in the legend including the ticks will be 256x15px
                canvas.width = "256";
                canvas.height = "15";

                grad = ctx.createLinearGradient(0, 5, 256, 10);

                for (var i = 0; i < length; i++) {
                    grad.addColorStop(1 / (length - 1) * i, gradArr[i].value);
                }

                ctx.fillStyle = grad;
                ctx.fillRect(0, 5, 256, 10);
                ctx.strokeStyle = "black";
                ctx.beginPath();

                for (var i = 0; i < length; i++) {
                    ctx.moveTo(((1 / (length - 1) * i * 256) >> 0) + .5, 0);
                    ctx.lineTo(((1 / (length - 1) * i * 256) >> 0) + .5, (i == 0) ? 15 : 5);
                }
                ctx.moveTo(255.5, 0);
                ctx.lineTo(255.5, 15);
                ctx.moveTo(255.5, 4.5);
                ctx.lineTo(0, 4.5);

                ctx.stroke();

                // we re-use the context for measuring the legends label widths
                me.set("ctx", ctx);

                return canvas.toDataURL();
            },
            getElement: function () {
                return this.get("element");
            },
            update: function (max) {
                var me = this,
                    gradient = me.get("gradientArr"),
                    ctx = me.get("ctx"),
                    labels = me.get("labelsEl"),
                    labelText, labelsHtml = "", offset;

                for (var i = 0; i < gradient.length; i++) {

                    labelText = max * gradient[i].stop >> 0;
                    offset = (ctx.measureText(labelText).width / 2) >> 0;

                    if (i == 0) {
                        offset = 0;
                    }
                    if (i == gradient.length - 1) {
                        offset *= 2;
                    }
                    labelsHtml += '<li style="position:absolute;left:' + (((((1 / (gradient.length - 1) * i * 256) || 0)) >> 0) - offset + .5) + 'px">' + labelText + '</li>';
                }
                labels.innerHTML = labelsHtml;
            }
        };

        // Mapgrid object constructor
        var Mapgrid = function Mapgrid(config) {
            // private variables
            var _ = {
                radius: 40,
                element: {},
                canvas: {},
                acanvas: {},
                ctx: {},
                actx: {},
                legend: null,
                visible: true,
                width: 0,
                height: 0,
                max: false,
                gradient: false,
                opacity: 180,
                premultiplyAlpha: false,
                bounds: {
                    l: 1000,
                    r: 0,
                    t: 1000,
                    b: 0
                },
                debug: false
            };
            // Mapgrid store containing the datapoints and information about the maximum
            // accessible via instance.store
            this.store = new store(this);

            this.get = function (key) {
                return _[key];
            };
            this.set = function (key, value) {
                _[key] = value;
            };
            // configure the Mapgrid when an instance gets created
            this.configure(config);
            // and initialize it
            this.init();
        };

        // public functions
        Mapgrid.prototype = {
            configure: function (config) {
                var me = this,
                    rout, rin;

                me.set("radius", config["radius"] || 40);
                me.set("element", (config.element instanceof Object) ? config.element : document.getElementById(config.element));
                me.set("visible", (config.visible != null) ? config.visible : true);
                me.set("max", config.max || false);
                me.set("gradient", config.gradient || {
                        0.45: "rgb(0,0,255)",
                        0.55: "rgb(0,255,255)",
                        0.65: "rgb(0,255,0)",
                        0.95: "yellow",
                        1.0: "rgb(255,0,0)"
                    });    // default is the common blue to red gradient
                me.set("opacity", parseInt(255 / (100 / config.opacity), 10) || 180);
                me.set("width", config.width || 0);
                me.set("height", config.height || 0);
                me.set("debug", config.debug);

                if (config.legend) {
                    var legendCfg = config.legend;
                    legendCfg.gradient = me.get("gradient");
                    me.set("legend", new legend(legendCfg));
                }

            },
            resize: function () {
                var me = this,
                    element = me.get("element"),
                    canvas = me.get("canvas"),
                    acanvas = me.get("acanvas");
                canvas.width = acanvas.width = me.get("width") || element.style.width.replace(/px/, "") || me.getWidth(element);
                this.set("width", canvas.width);
                canvas.height = acanvas.height = me.get("height") || element.style.height.replace(/px/, "") || me.getHeight(element);
                this.set("height", canvas.height);
                console.log(canvas.width, acanvas.width)
            },

            init: function () {
                var me = this,
                    canvas = document.createElement("canvas"),
                    acanvas = document.createElement("canvas"),
                    ctx = canvas.getContext("2d"),
                    actx = acanvas.getContext("2d"),
                    element = me.get("element");


                me.initColorPalette();

                me.set("canvas", canvas);
                me.set("ctx", ctx);
                me.set("acanvas", acanvas);
                me.set("actx", actx);

                me.resize();
                canvas.style.cssText = acanvas.style.cssText = "position:absolute;top:0;left:0;z-index:10000000;";

                if (!me.get("visible"))
                    canvas.style.display = "none";

                element.appendChild(canvas);
                if (me.get("legend")) {
                    element.appendChild(me.get("legend").getElement());
                }

                // debugging purposes only
                if (me.get("debug"))
                    document.body.appendChild(acanvas);

                actx.shadowOffsetX = 15000;
                actx.shadowOffsetY = 15000;
                actx.shadowBlur = 15;
            },
            initColorPalette: function () {

                var me = this,
                    canvas = document.createElement("canvas"),
                    gradient = me.get("gradient"),
                    ctx, grad, testData;

                canvas.width = "1";
                canvas.height = "256";
                ctx = canvas.getContext("2d");
                grad = ctx.createLinearGradient(0, 0, 1, 256);

                // Test how the browser renders alpha by setting a partially transparent pixel
                // and reading the result.  A good browser will return a value reasonably close
                // to what was set.  Some browsers (e.g. on Android) will return a ridiculously wrong value.
                testData = ctx.getImageData(0, 0, 1, 1);
                testData.data[0] = testData.data[3] = 64; // 25% red & alpha
                testData.data[1] = testData.data[2] = 0; // 0% blue & green
                ctx.putImageData(testData, 0, 0);
                testData = ctx.getImageData(0, 0, 1, 1);
                me.set("premultiplyAlpha", (testData.data[0] < 60 || testData.data[0] > 70));

                for (var x in gradient) {
                    grad.addColorStop(x, gradient[x]);
                }

                ctx.fillStyle = grad;
                ctx.fillRect(0, 0, 1, 256);

                me.set("gradient", ctx.getImageData(0, 0, 1, 256).data);
            },
            getWidth: function (element) {
                var width = element.offsetWidth;
                if (element.style.paddingLeft) {
                    width += element.style.paddingLeft;
                }
                if (element.style.paddingRight) {
                    width += element.style.paddingRight;
                }

                return width;
            },
            getHeight: function (element) {
                var height = element.offsetHeight;
                if (element.style.paddingTop) {
                    height += element.style.paddingTop;
                }
                if (element.style.paddingBottom) {
                    height += element.style.paddingBottom;
                }

                return height;
            },
            colorize: function (x, y) {
                // get the private variables
                var me = this,
                    width = me.get("width"),
                    radius = me.get("radius"),
                    height = me.get("height"),
                    actx = me.get("actx"),
                    ctx = me.get("ctx"),
                    x2 = radius * 3,
                    premultiplyAlpha = me.get("premultiplyAlpha"),
                    palette = me.get("gradient"),
                    opacity = me.get("opacity"),
                    bounds = me.get("bounds"),
                    left, top, bottom, right,
                    image, imageData, length, alpha, offset, finalAlpha;

                if (x != null && y != null) {
                    if (x + x2 > width) {
                        x = width - x2;
                    }
                    if (x < 0) {
                        x = 0;
                    }
                    if (y < 0) {
                        y = 0;
                    }
                    if (y + x2 > height) {
                        y = height - x2;
                    }
                    left = x;
                    top = y;
                    right = x + x2;
                    bottom = y + x2;

                } else {
                    if (bounds['l'] < 0) {
                        left = 0;
                    } else {
                        left = bounds['l'];
                    }
                    if (bounds['r'] > width) {
                        right = width;
                    } else {
                        right = bounds['r'];
                    }
                    if (bounds['t'] < 0) {
                        top = 0;
                    } else {
                        top = bounds['t'];
                    }
                    if (bounds['b'] > height) {
                        bottom = height;
                    } else {
                        bottom = bounds['b'];
                    }
                }

                image = actx.getImageData(left, top, right - left, bottom - top);
                imageData = image.data;
                length = imageData.length;
                // loop thru the area
                for (var i = 3; i < length; i += 4) {

                    // [0] -> r, [1] -> g, [2] -> b, [3] -> alpha
                    alpha = imageData[i],
                        offset = alpha * 4;

                    if (!offset)
                        continue;

                    // we ve started with i=3
                    // set the new r, g and b values
                    finalAlpha = (alpha < opacity) ? alpha : opacity;
                    imageData[i - 3] = palette[offset];
                    imageData[i - 2] = palette[offset + 1];
                    imageData[i - 1] = palette[offset + 2];

                    if (premultiplyAlpha) {
                        // To fix browsers that premultiply incorrectly, we'll pass in a value scaled
                        // appropriately so when the multiplication happens the correct value will result.
                        imageData[i - 3] /= 255 / finalAlpha;
                        imageData[i - 2] /= 255 / finalAlpha;
                        imageData[i - 1] /= 255 / finalAlpha;
                    }

                    // we want the Mapgrid to have a gradient from transparent to the colors
                    // as long as alpha is lower than the defined opacity (maximum), we'll use the alpha value
                    imageData[i] = finalAlpha;
                }
                // the rgb data manipulation didn't affect the ImageData object(defined on the top)
                // after the manipulation process we have to set the manipulated data to the ImageData object
                image.data = imageData;
                ctx.putImageData(image, left, top);
            },

            // 为了速度暂时不调用了
            getGridX: function(p, dw) {
                return parseInt(p.x / dw);
            },

            getGridY: function(p, dw) {
                return parseInt(p.y / dw);
            },

            // 100以下是蓝色，100-200是绿色，200-300是黄色，300-400是橙色，超过400是红色
            drawGridPointRect: function(ctx, x, y, dw, points)
            {
                var counts = 0;
                for (var i in points)
                {
                    var p = points[i];
                    counts += parseFloat( p['count'] );
                }
                var avg = counts / points.length;
                // console.log(counts, points.length, avg);

                var fillStyle = '';
                if (avg < 100) {
                    fillStyle = 'rgba(0, 0, 225, 0.5)';
                } else if (avg >= 100 && avg < 200) {
                    fillStyle = 'rgba(0, 255, 0, 0.5)';
                } else if (avg >= 200 && avg < 300) {
                    fillStyle = 'rgba(255, 255, 0, 0.5)';
                } else if (avg >= 300 && avg < 400) {
                    fillStyle = 'rgba(255, 80, 0, 0.5)';
                } else if (avg >= 400) {
                    fillStyle = 'rgba(255, 0, 0, 0.5)';
                }

                ctx.fillStyle = fillStyle;
                ctx.fillRect(x * dw, y * dw, dw, dw);
                ctx.fill();

            },

            drawGridPoints: function(ctx, bounds, dw) {

                var data = this.store.get("data");
                var pointsSet = [];
                var x = 0, y = 0, index = '';
                for (var i in data)
                {
                    // in format Object {x: 220, y: 19, count: 0}
                    // Has convert from lng/lat to x/y
                    var item = data[i];
                    // console.log(item.x)
                    x = parseInt(item.x / dw), y = parseInt(item.y / dw);
                    index = "{x},{y}".format({x:x, y:y});
                    if (pointsSet[index]) {
                        pointsSet[index].push(item);
                    } else {
                        pointsSet[index] = [item];
                    }
                }

                for (var index in pointsSet)
                {
                    var points = pointsSet[index];
                    var i = index.split(',');
                    var x = parseInt(i[0]);
                    var y = parseInt(i[1]);

                    this.drawGridPointRect(ctx, x, y, dw, points);
                }
            },

            drawGrid: function (bounds) {
                // storing the variables because they will be often used
                var me = this,
                    radius = me.get("radius"),
                    ctx = me.get("ctx"),
                    max = me.get("max");
                    //bounds = me.get("bounds");
                    //xb = x - (1.5 * radius) >> 0, yb = y - (1.5 * radius) >> 0,
                    //xc = x + (1.5 * radius) >> 0, yc = y + (1.5 * radius) >> 0;

                var cc = 100;

                var width = me.get("width"), height = me.get("height");
                console.log("Wwidth", width);

                var dw = width / cc, dh = height / cc;
                // dw = dw;
                if (bounds)
                {
                   // var lanSpan = (bounds.toSpan().lng);
                    //var latSpan = (bounds.toSpan().lat);
                }

                ctx.fillStyle = "#FF0000";
                ctx.lineCap = 'square';
                ctx.lineWidth = 0.1;
                var x = 0, y = 0;
                ctx.beginPath();
                for (var i = 0; i < cc; i++) {
                    x = i * dw;
                    y = i * dw;
                    // |||| Vertical line

                    ctx.moveTo(x, 0);
                    ctx.lineTo(x, height);
                    ctx.stroke();

                    // ------------
                    ctx.beginPath();
                    ctx.moveTo(0, y);
                    ctx.lineTo(width, y);
                    ctx.stroke();

                }
                ctx.closePath();
                ctx.fill();
                this.drawGridPoints(ctx, bounds, dw, 0);

                console.log('after-drawGrid')

            },


            drawAlpha: function (x, y, count, colorize) {
                console.log('drawAlpha')
                return;
                // storing the variables because they will be often used
                var me = this,
                    radius = me.get("radius"),
                    ctx = me.get("actx"),
                    max = me.get("max"),
                    bounds = me.get("bounds"),
                    xb = x - (1.5 * radius) >> 0, yb = y - (1.5 * radius) >> 0,
                    xc = x + (1.5 * radius) >> 0, yc = y + (1.5 * radius) >> 0;

                ctx.shadowColor = ('rgba(0,0,0,' + ((count) ? (count / me.store.max) : '0.1') + ')');

                ctx.shadowOffsetX = 15000;
                ctx.shadowOffsetY = 15000;
                ctx.shadowBlur = 15;

                ctx.beginPath();
                ctx.arc(x - 15000, y - 15000, radius, 0, Math.PI * 2, true);
                ctx.closePath();
                ctx.fill();
                if (colorize) {
                    // finally colorize the area
                    me.colorize(xb, yb);
                } else {
                    // or update the boundaries for the area that then should be colorized
                    if (xb < bounds["l"]) {
                        bounds["l"] = xb;
                    }
                    if (yb < bounds["t"]) {
                        bounds["t"] = yb;
                    }
                    if (xc > bounds['r']) {
                        bounds['r'] = xc;
                    }
                    if (yc > bounds['b']) {
                        bounds['b'] = yc;
                    }
                }
            },
            toggleDisplay: function () {
                var me = this,
                    visible = me.get("visible"),
                    canvas = me.get("canvas");

                if (!visible)
                    canvas.style.display = "block";
                else
                    canvas.style.display = "none";

                me.set("visible", !visible);
            },
            // dataURL export
            getImageData: function () {
                return this.get("canvas").toDataURL();
            },
            clear: function () {
                console.log('clear')
                var me = this,
                    w = me.get("width"),
                    h = me.get("height");

                me.store.set("data", []);
                // @TODO: reset stores max to 1
                //me.store.max = 1;
                me.get("ctx").clearRect(0, 0, w, h);
                me.get("actx").clearRect(0, 0, w, h);
            },
            cleanup: function () {
                var me = this;
                me.get("element").removeChild(me.get("canvas"));
            }
        };

        return {
            create: function (config) {
                return new Mapgrid(config);
            },
            util: {
                mousePosition: function (ev) {
                    // this doesn't work right
                    // rather use
                    /*
                     // this = element to observe
                     var x = ev.pageX - this.offsetLeft;
                     var y = ev.pageY - this.offsetTop;

                     */
                    var x, y;

                    if (ev.layerX) { // Firefox
                        x = ev.layerX;
                        y = ev.layerY;
                    } else if (ev.offsetX) { // Opera
                        x = ev.offsetX;
                        y = ev.offsetY;
                    }
                    if (typeof(x) == 'undefined')
                        return;

                    return [x, y];
                }
            }
        };
    })();
    w.h337 = w.MapgridFactory = MapgridFactory;
})(window);

/**
 * @fileoverview 百度地图的辐射网格图
 * @author Healer Kx
 * @version 0.1
 */
var BMapLib = window.BMapLib = BMapLib || {};

(function () {

    // Grid辐射分布图覆盖物
    var MapgridOverlay = BMapLib.MapgridOverlay = function (opts) {
        this.conf = opts;
        this.Mapgrid = null;
        this.latlngs = [];
        this.bounds = null;
    };

    MapgridOverlay.prototype = new BMap.Overlay();

    MapgridOverlay.prototype.initialize = function (map) {
        this._map = map;
        var el = document.createElement("div");
        el.style.position = "absolute";
        el.style.top = 0;
        el.style.left = 0;
        el.style.border = 0;
        el.style.width = this._map.getSize().width + "px";
        el.style.height = this._map.getSize().height + "px";
        this.conf.element = el;
        map.getPanes().mapPane.appendChild(el);
        this.Mapgrid = h337.create(this.conf);
        this._div = el;
        return el;
    };

    // TODO:-----------
    MapgridOverlay.prototype.redraw = function () {
        this.bounds = null;
        this.draw();
        //
    };

    MapgridOverlay.prototype.draw = function () {

        var currentBounds = this._map.getBounds();

        if (currentBounds.equals(this.bounds)) {
            return;
        }

        this.bounds = currentBounds;

        var ne = this._map.pointToOverlayPixel(currentBounds.getNorthEast()),
            sw = this._map.pointToOverlayPixel(currentBounds.getSouthWest()),
            topY = ne.y,
            leftX = sw.x,
            h = sw.y - ne.y,
            w = ne.x - sw.x;
        console.log(ne, sw, w);
        this.conf.element.style.left = leftX + 'px';
        this.conf.element.style.top = topY + 'px';
        this.conf.element.style.width = w + 'px';
        this.conf.element.style.height = h + 'px';
        // Fix BUG: Map's right edge can NOT be covered by grid!
        this.Mapgrid.set('width', w);
        this.Mapgrid.store.get("Mapgrid").resize();

        if (this.latlngs.length > 0) {
            this.Mapgrid.clear();

            var len = this.latlngs.length;
            d = {
                max: this.Mapgrid.store.max,
                data: []
            };

            while (len--) {
                var latlng = this.latlngs[len].latlng;

                if (!currentBounds.containsPoint(latlng)) {
                    continue;
                }

                var divPixel = this._map.pointToOverlayPixel(latlng),
                    screenPixel = new BMap.Pixel(divPixel.x - leftX, divPixel.y - topY);
                var roundedPoint = this.pixelTransform(screenPixel);
                d.data.push({
                    x: roundedPoint.x,
                    y: roundedPoint.y,
                    count: this.latlngs[len].c
                });
            }
            this.Mapgrid.store.setDataSet(d);

        }
        // this.Mapgrid.colorize();
        this.Mapgrid.drawGrid(this.bounds);
    };


    //内部使用的坐标转化
    MapgridOverlay.prototype.pixelTransform = function (p) {
        var w = this.Mapgrid.get("width"),
            h = this.Mapgrid.get("height");

        while (p.x < 0) {
            p.x += w;
        }

        // Why do this?
        /*
        while (p.x > w) {
            p.x -= w;
        }*/

        while (p.y < 0) {
            p.y += h;
        }

        while (p.y > h) {
            p.y -= h;
        }

        p.x = (p.x >> 0);
        p.y = (p.y >> 0);

        return p;
    }

    /**
     * 设置热力图展现的详细数据, 实现之后,即可以立刻展现
     * @param {Json Object } data
     * {"<b>max</b>" : {Number} 权重的最大值,
     * <br />"<b>data</b>" : {Array} 坐标详细数据,格式如下 <br/>
     * {"lng":116.421969,"lat":39.913527,"count":3}, 其中<br/>
     * lng lat分别为经纬度, count权重值
     */
    MapgridOverlay.prototype.setDataSet = function (data) {

        var currentBounds = this._map.getBounds();
        var mapdata = {
            max: data.max,
            data: []
        };
        var d = data.data,
            dlen = d.length;


        this.latlngs = [];

        while (dlen--) {
            var latlng = new BMap.Point(d[dlen].lng, d[dlen].lat);
            if (!currentBounds.containsPoint(latlng)) {
                continue;
            }
            this.latlngs.push({
                latlng: latlng,
                c: d[dlen].count
            });

            var divPixel = this._map.pointToOverlayPixel(latlng),
                leftX = this._map.pointToOverlayPixel(currentBounds.getSouthWest()).x,
                topY = this._map.pointToOverlayPixel(currentBounds.getNorthEast()).y,
                screenPixel = new BMap.Pixel(divPixel.x - leftX, divPixel.y - topY);
            var point = this.pixelTransform(screenPixel);

            mapdata.data.push({
                x: point.x,
                y: point.y,
                count: d[dlen].count
            });
        }
        this.Mapgrid.clear();
        this.Mapgrid.store.setDataSet(mapdata);
    };

    /**
     * 添加势力图的详细坐标点
     * @param {Number} lng 经度坐标
     * @param {Number} lat 经度坐标
     * @param {Number} count 经度坐标
     */
    MapgridOverlay.prototype.addDataPoint = function (lng, lat, count) {
        var latlng = new BMap.Point(lng, lat),
            point = this.pixelTransform(this._map.pointToOverlayPixel(latlng));

        this.Mapgrid.store.addDataPoint(point.x, point.y, count);
        this.latlngs.push({
            latlng: latlng,
            c: count
        });
    };

    /**
     * 更改图的展现或者关闭
     */
    MapgridOverlay.prototype.toggle = function () {
        this.Mapgrid.toggleDisplay();
    };

    BMapLib.MapgridOverlay = MapgridOverlay; // 向命名空间注册.
})();
