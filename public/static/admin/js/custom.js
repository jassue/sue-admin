$.modal = {
    alert: function (obj) {
        let title = (obj == undefined || obj.title == undefined) ? '温馨提示' : obj.title
        let msg = (obj == undefined || obj.msg == undefined) ? '' : obj.msg
        let callback = (obj == undefined || obj.callback == undefined) ? '' : obj.callback
        let modal = '<div id="ui_alert" class="modal fade">\n' +
            '                <div class="modal-dialog" role="document">\n' +
            '                  <div class="modal-content">\n' +
            '                    <div class="modal-header">\n' +
            '                      <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>\n' +
            '                      <h5 class="modal-title">' + title + '</h5>\n' +
            '                    </div>\n' +
            '                    <div class="modal-body">\n' +
            '                      <p>' + msg + '</p>\n' +
            '                    </div>\n' +
            '                    <div class="modal-footer">\n' +
            '                      <button class="btn btn-primary btn-sm" type="button" data-dismiss="modal">确定</button>\n' +
            '                    </div>\n' +
            '                  </div>\n' +
            '                </div>\n' +
            '              </div>\n' +
            '            </div>'
        $('body').append(modal)
        $('#ui_alert').modal({backdrop: 'static'})
        $('#ui_alert').modal('show')
        $('#ui_alert').on('hidden.bs.modal', function (e) {
            if (callback != '') {
                callback()
            }
            $('#ui_alert').remove()
        })
    },
    confirm: function (obj) {
        let title = (obj == undefined || obj.title == undefined) ? '温馨提示' : obj.title
        let msg = (obj == undefined || obj.msg == undefined) ? '' : obj.msg
        let callback = ''
        let modal = '<div id="ui_confirm" class="modal fade">\n' +
            '                <div class="modal-dialog" role="document">\n' +
            '                  <div class="modal-content">\n' +
            '                    <div class="modal-header">\n' +
            '                      <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>\n' +
            '                      <h5 class="modal-title">' + title + '</h5>\n' +
            '                    </div>\n' +
            '                    <div class="modal-body">\n' +
            '                      <p>' + msg + '</p>\n' +
            '                    </div>\n' +
            '                    <div class="modal-footer">\n' +
            '                      <button id="confirm_ok" class="btn btn-primary btn-sm" type="button">确定</button>\n' +
            '                      <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">取消</button>\n' +
            '                    </div>\n' +
            '                  </div>\n' +
            '                </div>\n' +
            '              </div>\n' +
            '            </div>'
        $('body').append(modal)
        $('#ui_confirm').modal({backdrop: 'static'})
        $('#ui_confirm').modal('show')
        $('#confirm_ok').on('click', function () {
            callback = (obj == undefined || obj.yes == undefined) ? '' : obj.yes
            $('#ui_confirm').modal('hide')
        })
        $('#ui_confirm').on('hidden.bs.modal', function (e) {
            $('#ui_confirm').remove()
            if (callback != '') {
                callback()
            }
        })
    },
    open: function (page) {
        let html = (page == undefined || page.html == undefined) ? '' : page.html
        let title = (page == undefined || page.title == undefined) ? '' : page.title
        let width = (page == undefined || page.width == undefined) ? '600px' : page.width
        let height = (page == undefined || page.height == undefined) ? 'auto' : page.height
        let modal = '<div id="ui_open" class="modal fade">\n' +
            '                <div class="modal-dialog" role="document" style="margin-top: 60px;max-width: ' + width + '">\n' +
            '                  <div class="modal-content">\n' +
            '                    <div class="modal-header">\n' +
            '                      <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>\n' +
            '                      <h5 class="modal-title">' + title + '</h5>\n' +
            '                    </div>\n' +
            '                    <div class="modal-body" style="height: ' + height + '">\n' +
            '                      ' + html + '\n' +
            '                    </div>\n' +
            '                  </div>\n' +
            '                </div>\n' +
            '              </div>\n' +
            '            </div>'
        $('body').append(modal)
        $('#ui_open').modal({backdrop: 'static'})
        $('#ui_open').modal('show')
        $('#ui_open').on('hidden.bs.modal', function (e) {
            $('#ui_open').remove()
        })
    }
}