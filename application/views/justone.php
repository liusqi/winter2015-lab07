<div style="padding:50px; padding-top:10px;">
    <div class="row">
        <h3>{order} for {customer} ({order-type})</h3>
        <p>Special Instructions: <i>{special}</i></p>

        {burgers}
        <p>Burger #{count}</p><i>{name}</i>
        <ul>
            <li>Base: {pattyBurger}</li>
            {cheeseList}
            <li>Topping(s): {toppingList}</li>
            <li>Sauce(s): {sauceList}</li>
            {instructions}
            <br/>
            <p>Burger total: ${total}</p>
        </ul>
        {/burgers}
        <p>Order total: ${total}</p>
        <a href="/welcome">Back</a>
    </div>
</div>