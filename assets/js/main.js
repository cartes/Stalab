jQuery(document).ready(function ($) {
    var initsearch = function () {
        var $this = $('#adSearch');
        console.log(stalab_var.rest_api_url + $this.val());

        if ($this.val().length >= 3) {
            $.ajax({
                url: stalab_var.rest_api_url + $this.val(),
                type: 'get',
                cache: false,
                beforeSend: function () {
                    $('.listSearch')
                        .empty()
                        .show()
                        .html('<h3>Buscando...</h3>');
                    if (!($('.backover').length)) {
                        $('#main-content').find('.form-group').append("<div class='backover'></div>");
                    }
                    $('.backover').css({
                        'position': 'fixed',
                        'top': '0px',
                        'left': '0px',
                        'width': '100%',
                        'height': '100%',
                        'display': 'block',
                        'z-index': '30',
                        'background-color': 'transparent'
                    }).click(function (e) {
                        e.preventDefault();
                        $('.listSearch').empty().hide();
                        $('#adSearch').val("");
                        initsearch();
                        $(this).remove();
                    })
                },
            }).done(function (data) {
                $('.listSearch').empty().css({
                    'position': 'absolute',
                    'z-index': '100'
                }).show();
                $.each(data, function (i, obj) {
                    $('.listSearch').append('<h3 class="list-group-item alignleft" data-id="' + obj.term_id + '"><a href="#">' + obj.name + '</a></h3>');
                });
                clickItem();
            });
        }
    };

    var clickItem = function() {
        $('.list-group-item').click(function(e) {
            e.preventDefault();
            var txt = $(this)[0].innerText;
            $('#adSearch').val(txt);
            $('.listSearch').empty().hide();
            $('#product-search').submit();
        });
    }

    var timer = 0;
    $('#adSearch').live('keyup', function (e) {
        if (timer) {
            clearTimeout(timer);
        }
        timer = setTimeout(initsearch, 400);
    });

    var searchOpts = function (opt) {
        var action;
        switch (opt) {
            case 1:
                action = 'stalabAlpha';
                break;
            case 2:
                action = 'stalabBrand';
                break;
            case 3:
                action = 'stalabAccesories';
                break;
            case 4:
                action = "stalabApp";
                break;
            case 5:
                action = "stalabMuestra";
                break;
            case 6:
                action = "stalabCampoApp";
                break;
        }
        $.ajax({
            url: stalab_var.ajaxurl,
            type: 'post',
            data: {
                action: action
            },
            beforeSend: function () {
                $('.results').html('<h3>Buscando...</h3>');
            },
            success: function (response) {
                $('.results').empty().html(response);
                afterSuccess();
                previewPage();
            }
        });
    }

    $('.dropdown-item').click(function () {
        var $this = $(this);
        var opt = parseInt($this.data('value'));

        searchOpts(opt);
    });

    var querySearch = function (taxonomy, field, opt, operator = 'IN') {
        $.ajax({
            url: stalab_var.ajaxurl,
            type: 'post',
            data: {
                action: 'ajax_query',
                tax: taxonomy,
                field: field,
                search: opt,
                operator: operator
            },
            beforeSend: function () {
                $('.results').html('<h3>Buscando...</h3>');
            },
            success: function (response) {
                $('.results').empty().html(response);
                previewPage();
            }
        })
    };

    var afterSuccess = function () {
        /**
         * Busca el query por Marca
         */
        $('.searchWordBrand').click(function (e) {
            e.preventDefault();
            var $this = $(this);
            var data = $this.data('value');

            querySearch('brands', 'name', data);
        });

        /**
         * Busca el query por Aplicación
         */
        $('.searchWordApp').click(function (e) {
            e.preventDefault();
            var $this = $(this);
            var data = $this.data('value');

            console.log(data);

            querySearch('aplicacion', 'slug', data);
        });

        /**
         * Busca el query por Tipo de Muestra
         */
        $('.searchWordMuestra').click(function (e) {
            e.preventDefault();
            var $this = $(this);
            var data = $this.data('value');

            querySearch('muestra', 'name', data);
        });

        /**
         * Busca el query por Campo Aplicación
         */
        $('.searchWordCampo').click(function (e) {
            e.preventDefault();
            var $this = $(this);
            var data = $this.data('value');

            querySearch('campo', 'name', data);
        });

        /**
         * Busca el query por Campo Aplicación
         */
        $('.searchWordAlpha').click(function (e) {
            e.preventDefault();
            var $this = $(this);
            var data = $this.data('value');

            data = data
                .normalize("NFD").replace(/[\u0300-\u036f]/g, "")
                .toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');

            querySearch('prod_type', 'slug', data)

        });
    };

    var previewPage = function () {
        $('.previewBtn').mouseenter(function () {
            var dataId = $(this).parent('h3').data('id');
            $(this).parent('h3').append("<div class='pre'></div>");
            $('.pre').css({
                'position': 'absolute',
                'top': '27px',
                'right': '0px',
                'background-color': '#fff',
                'border': "1px solid #999",
                'padding': '10px',
                'z-index': '10000',
                'max-width': '250px',

            });

            $.ajax({
                url: stalab_var.ajaxurl,
                type: 'post',
                data: {
                    action: 'show_preview',
                    id: dataId
                },
                beforeSend: function () {
                    $('.pre').empty().append('Cargando...');
                },
                success: function (response) {
                    $('.pre').empty().html(response);
                }
            });
        });
        $('.previewBtn').mouseleave(function () {
            $(".pre").empty().remove();
        });
    };


    function strip(html) {
        var tmp = document.createElement("DIV");
        tmp.innerHTML = html;
        return tmp.textContent || tmp.innerText || "";
    }

    function toDataUrl(url, callback) {
        var httpRequest = new XMLHttpRequest();

        httpRequest.onload = function () {
            var fileReader = new FileReader();
            fileReader.onloadend = function () {
                callback(fileReader.result);
            };
            fileReader.readAsDataURL(httpRequest.response);
        };
        httpRequest.open('GET', url);
        httpRequest.responseType = 'blob';
        httpRequest.send();
    }

    function convertToSlug(Text) {
        return Text
            .toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-')
            ;
    }

    /**
     * Construcción de la ficha del PDF
     * @type {jsPDF}
     */


    function getImageData(data, callback) {
        var image = new Image();
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');

        image.onload = function () {
            canvas.width = this.naturalWidth;
            canvas.height = this.naturalHeight;

            ctx.drawImage(this, 0, 0);
            ctx.globalCompositeOperation = 'destination-over';
            ctx.fillStyle = '#fff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            callback(canvas.toDataURL('image/jpeg', 1));
        }

        image.src = data;

    }

    var footerImg = document.createElement('img');
    footerImg.src = window.location.origin + '/stalab/imgs/footer-100.jpg';

    var dataFooter = getImageData(footerImg.src, function (data) {
        footerImg.attributes.src.nodeValue = data;
    });

    var img = $('#contentPDF').find('img');
    var brand = $('.site-logo-image').find('img');
    var url = brand[0].currentSrc;

    var dataBrand = getImageData(url, function (data) {
        brand[0].attributes.src.nodeValue = data;
    });

    img.each(function (key, value) {
        var url = value.currentSrc;
        var dataImage = getImageData(url, function (data) {
            value.attributes.src.nodeValue = data;
        });
    });

    $('.downloadPDF').click(function () {
        var pdf = new jsPDF('p', 'pt', 'letter');
        var canvas = pdf.canvas;

        var options = {
            format: 'JPEG',
            pagesplit: true,
            background: '#fff',
        };

        $('html').animate({scrollTop: 0}, 300, 'linear', function () {
            var firstPage = document.getElementById('prod-ficha'),
                secondPage = document.getElementById('tablePDF'),
                firstEl = firstPage.cloneNode(true),
                secondEl = secondPage.cloneNode(true),
                divHtml = document.createElement('div');

            firstEl.style.fontFamily = "arial,helvetica,sans-serif";
            firstEl.style.fontSize = "30px";
            firstEl.style.color = '#1FA5D2';
            firstEl.style.textAlign = 'center';

            secondEl.style.fontFamily = "arial,helvetica,sans-serif";
            secondEl.style.fontSize = "10px";

            divHtml.setAttribute('id', 'toPDF');
            divHtml.appendChild(firstEl);

            var margins = {
                top: 50,
                bottom: 10,
                left: 0,
                right: 0,
                width: 210,
            };
            pdf.setFontSize(20);
            pdf.setTextColor(4, 154, 231);

            var originalTxt = firstEl.innerHTML;
            var txt = pdf.splitTextToSize(originalTxt, 420);
            var logo = $('.site-logo-image').find('img');

            var pageWidth = pdf.internal.pageSize.width;
            var fontSize = pdf.internal.getFontSize();

            for (i = 0; i < txt.length; i++) {
                var txtWidth = pdf.getStringUnitWidth(txt[i]) * fontSize / pdf.internal.scaleFactor;
                var posX = (pageWidth - txtWidth) / 2;


                pdf.text(txt[i], posX, 100 + (i * 25));
            }

            pdf.autoTable({
                html: "#descripcion-table",
                tableWidth: 280,
                startY: 170,
                theme: 'plain',
                styles: {
                    minCellWidth: 300,
                    halign: 'justify'
                },
                didParseCell: function (data) {
                    if (firstEl.id == "prod-ficha") {
                        data.cell.text[0] = '';
                    }


                    if (data.cell.raw.className === 'logoMarca') {
                        var img = $('.logoMarca').find('img');
                        var alto = img[0].clientHeight * 0.7;
                        data.cell.styles.minCellHeight = alto + 10;
                    }

                    if (data.cell.raw.className == 'descripcion text-justify') {

                        var doc = new DOMParser().parseFromString(data.cell.raw.innerHTML, "text/html");
                        var prg = doc.getElementsByTagName("p");
                        // var txts = prg[0].children;
                        var parrag = [];
                        for (i = 0; i < prg.length; i++) {
                            parrag[i] = prg[i].innerHTML.replace(/["']/g, "");
                        }

                        data.cell.text = parrag;
                        data.cell.styles.fontSize = 7;
                        data.cell.styles.lineHeight = 10;

                    }


                },
                didDrawCell: function (data) {
                    if (data.cell.raw.className === 'logoMarca') {
                        var img = $('.logoMarca').find('img');
                        var dim = data.cell.height - data.cell.padding('vertical');
                        var txtPos = data.cell.textPos;

                        pdf.addImage(img[0].src, txtPos.x, txtPos.y, img[0].clientWidth * 0.5, img[0].clientHeight * 0.5);
                    }

                },
            });

            var image = $('#img-table').find('img');
            pdf.addImage(image[0].src, 350, 170, image[0].clientWidth * 0.5, image[0].clientHeight * 0.5);

            pdf.autoTable({
                html: "#table-campos",
                tableWidth: 520,
                startY: pdf.lastAutoTable.height + 180,
                theme: 'plain',
                didParseCell: function (data) {
                    if (data.cell.raw.className == 'subtitle' || data.cell.raw.className == 'py-2 row subtitle') {
                        data.cell.styles.fontStyle = 'bold';
                        data.cell.styles.fontSize = 13;
                        data.cell.styles.textColor = [4, 154, 231];
                    } else {
                        data.cell.styles.fontSize = 7;
                    }
                }
            });

            pdf.addPage();

            pdf.autoTable({
                html: "#caracteristicas",
                tableWidth: 520,
                startY: 70,
                styles: {
                    minCellWidth: 150,
                    fontSize: 8,
                },
            });

            var title = divHtml.textContent;

            var numPages = pdf.internal.getNumberOfPages();

            for (var i = 1; i <= numPages; i++) {
                pdf.setPage(i);
                pdf.addImage(logo[0].src, 30, 25, logo[0].clientWidth * 0.9, logo[0].clientHeight * 0.9);
                pdf.setFontSize(8);

                pdf.addImage(footerImg.src, 0, 680, footerImg.naturalWidth * 0.681, footerImg.naturalHeight * 0.681);

                // pdf.text('STALAB | Román Díaz 462, Providencia, Santiago', 30, 780, {align: "justify"});
            }

            pdf.save('Ficha ' + title + '.pdf');

        });
    });
    
    jQuery.fn.onPositionChanged = function (trigger, millis) {
        if (millis == null) millis = 100;
        var o = $(this[0]);
        if (o.length < 1) return o;

        var lastPos = null;
        var lastOff = null;

        setInterval(function () {
            if (o == null || o.length < 1) return o;
            if (lastPos == null) lastPos = o.position();
            if (lastOff == null) lastOff = o.offset();
            var newPos = o.position();
            var newOff = o.offset();


            if (lastPos.top != newPos.top || lastPos.left != newPos.left) {
                $(this).trigger('onPositionChanged', {lastPos: lastPos, newPos: newPos});
                if (typeof trigger == 'function') trigger(lastPos, newPos);
                lastPos = o.position();
            }
            
            // if (lastOff.top != newOff.top || lastOff.left != newOff.left) {
            //     $(this).trigger('onOffsetChanged', {lastOff: lastOff, newOff: newOff});
            //     if (typeof trigger == 'function') trigger(lastOff, newOff);
            //     lastOff = o.offset();
            // }
        }, millis);

        return o;
    }

    $(document).ready(function() {
        $('.lshowcase-wrap-carousel-2').onPositionChanged(function (x, y) {
            console.log('Detuvo');
        }, 1000);

    })


});