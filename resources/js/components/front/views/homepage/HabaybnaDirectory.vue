<template>
    <section class="directory-section pt-35 pb-35">
        <div class="container">
            <h2 class="white bold font-26 mb-15">دليل حبايبنا</h2>

            <div class="box mt-10">
                <div class="filter-box d-flex">
                    <select class="disfunctions ml-10 pointer w-30">
                        <option>إعاقات بصرية</option>
                    </select>
                    <select class="disfunctions ml-10 pointer w-30">
                        <option>إعاقات بصرية</option>
                    </select>
                    <div>
                        <router-link
                            class="btn-search font-18 radius-5 flex-all"
                            to="/"
                            title=""
                        >
                            <img
                                width="18"
                                height="18"
                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAABHNCSVQICAgIfAhkiAAAAUBJREFUOE+tk2FRw0AQhb9VACiAOqgDigJAAeCgDkgVUAeAAkABrQKoAloHoOAxL3PJXMMlgRnuV+Zm79u3722CkSPpGjgHLlLpFlgBi4jwd32ijyPpEHgFpgO9qohY9II6kC+gAp6tQNIMsMqr1MDKqqIiSX54C+ysKCI+u6rSyPfpftIH8sMD4Cwi7EfxSHpIyh5/gJJ0e7OLiJOhLLLabQnkdJ6AdUTYj8EjSUWzsy6jIElO9K0P5HE+koyjktGNxCyUlz6zbfBpivyyNJskN7Qa79tNH6iVbFhdmK1AGt/RG7aJiGnJbEPugAlwnKlp1sCPmzQ3wMxN9kDJPEdvuWtgDizTmPmE3nbfLxulLagDcaE7vft18qPdqdKS1qAhyNgetX//f0DqPZLURL03zm+V5IpsrCOeN578FeL6b9oTlqu5Z90OAAAAAElFTkSuQmCC"
                                alt="search"
                        /></router-link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script></script>
<style scoped>
.directory-section {
    background: linear-gradient(
            90deg,
            rgba(0, 0, 0, 0.2637429971988795) 0%,
            rgba(0, 0, 0, 0.26) 100%
        ),
        url(http://cms.habaybna.net/sites/default/files/styles/directory_background_image/public/2020-04/bg.jpg?itok=P3pto-K2)
            top center / cover no-repeat;
}
.filter-box select {
    height: 50px;
}
.btn-search {
    background: #4cbc15;
    color: #fff;
    width: 81px;
    height: 49px;
}
</style>
