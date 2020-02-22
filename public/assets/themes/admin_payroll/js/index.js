/* 
 * The MIT License
 *
 * Copyright Error: on line 6, column 29 in Templates/Licenses/license-mit.txt
 The string doesn't match the expected date/time format. The string to parse was: "23 Jan 16". The expected format was: "MMM d, yyyy". Tris.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

$(function () {
    $('a.uee-del-action').click(function () {
        var delurl = $(this).attr('data-del-url');
        var delidelconfelmid = $(this).attr('data-del-conf-elm-id');
        var delconfirm = $('#' + delidelconfelmid).text();

        var delfrmid = $(this).attr('data-del-frmid');
        
        $('#' + delfrmid).attr('action', delurl);
        var delinpid = $('#' + $(this).attr('data-del-input-id'));
        delinpid.val($(this).attr('data-del-input'));

        var delinptok = $('#' + $(this).attr('data-del-input-token'));
        delinptok.val($(this).attr('data-del-token'));
        if (confirm(delconfirm)) $('#' + delfrmid).submit();

        return false;
    });
    $('a.uee-postdata-action').click(function () {
        var delurl = $(this).attr('data-postdata-url');
        var delidelconfelmid = $(this).attr('data-postdata-conf-elm-id');
        var delconfirm = $('#' + delidelconfelmid).text();

        var delfrmid = $(this).attr('data-postdata-frmid');
        
        $('#' + delfrmid).attr('action', delurl);
        var delinpid = $('#' + $(this).attr('data-postdata-input-id'));
        delinpid.val($(this).attr('data-postdata-input'));

        var delinptok = $('#' + $(this).attr('data-postdata-input-token'));
        delinptok.val($(this).attr('data-postdata-token'));
        if (confirm(delconfirm)) $('#' + delfrmid).submit();

        return false;
    });
});
