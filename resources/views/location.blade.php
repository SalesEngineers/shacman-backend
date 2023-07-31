<table>
    <tbody>
        @if ($ip)
        <tr>
            <td>IP:</td>
            <td><input type="text" onclick="this.select()" value="<?php echo $ip; ?>" readonly></td>
        </tr>
        @endif
        @if (isset($location['city']))
        <tr>
            <td>Город:</td>
            <td><input type="text" onclick="this.select()" value="<?php echo $location['city']; ?>" readonly></td>
        </tr>
        @endif
        @if (isset($location['region']))
        <tr>
            <td>Регион:</td>
            <td><input type="text" onclick="this.select()" value="<?php echo $location['region']; ?>" readonly></td>
        </tr>
        @endif
    </tbody>
</table>