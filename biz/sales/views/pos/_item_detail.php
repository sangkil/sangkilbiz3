<td style="width: 50px">
    <a data-action="delete" title="Delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
    <input type="hidden" data-field="price"><input type="hidden" data-field="id_uom">
    <input type="hidden" data-field="id_product">
</td>
<td>
    <ul class="nav nav-list">
        <li class="item">
            <span data-text="nm_product"></span>
        </li>
        <li class="qty">
            Jumlah <input type="text" size="5" data-field="qty" value="1"> <span data-text="nm_uom"></span>
            @ Rp<span data-text="price"></span>
        </li>
        <li class="discon">
            Discon <input type="text" size="5" data-field="discon"> %

        </li>
    </ul>
</td>
<td class="total-price">
    <input type="hidden" data-field="total_price"><span data-text="total_price"></span>
</td>