<table>
    <tbody>
        @if ($location['city'])
        <tr>
            <td>Город:</td>
            <td><input type="text" onclick="this.select()" value="<?php echo $location['city']; ?>" readonly></td>
        </tr>
        @endif
        @if ($location['region'])
        <tr>
            <td>Регион:</td>
            <td><input type="text" onclick="this.select()" value="<?php echo $location['region']; ?>" readonly></td>
        </tr>
        @endif
    </tbody>
</table>