<template>
    <div class="header">
        <div class="headerinfo">
            <div class="headertype">
                <h3>Stock Adjustment Details</h3>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div v-if="stockAdjustment.length > 0" class="print">
            <span>#: {{ stockAdjustment[0].saj_no }}</span>
            <span style="cursor: pointer;" @click="downloadPDF"><i class="fa-solid fa-print mx-2"
                    style="font-size: 20px;"></i>Print</span>
        </div>
        <hr>
        <div id="PDFinvoice">
            <div style="text-align:center;">
                <font
                    style="text-align:center;vertical-align: inherit;font-size:16px;color:white;background-color:#9D568A;padding:10px;padding-inline: 60px;font-weight:bold;line-height: 35px; ">
                    Stock Adjustment</font><br>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-12" style="vertical-align:top;text-align:left;"><!--!-->

                    <font style="vertical-align: inherit;font-size:14px;color:#9D568A;font-weight:600;line-height: 35px; ">
                        Company Info
                    </font>
                    <br>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">{{ userName }}
                        </font>
                    </font><!--!--><br>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                            {{ userEmail }}</font>
                    </font><br>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                        {{ userPhone }}</font>
                    </font><br>
                    <!-- <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">Marina,
                            Dubai, United Arab Emirates</font>
                    </font><br> -->
                </div>

                <div v-if="stockAdjustment.length > 0" class="col-lg-6 col-md-6 col-12"
                    style="vertical-align:top;text-align:right;"><!--!-->
                    <font style="vertical-align: inherit;margin-bottom:25px;">
                        <font
                            style="vertical-align: inherit;font-size:14px;color:#9D568A;font-weight:600;line-height: 35px; ">
                            Stock Adjustment</font>
                    </font><br>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">Location:
                            {{ stockAdjustment[0].location.name }}</font>
                    </font><!--!--><br>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">No:
                            {{ stockAdjustment[0].saj_no }}</font>
                    </font><!--!--><br>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">Date:
                            {{ stockAdjustment[0].date }}</font>
                    </font><!--!--><br>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">Type:
                            {{ stockAdjustment[0].type }}</font>
                    </font><!--!--><br>
                </div>
            </div>
            <div class="invoice-box">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th>Product</th>
                            <th>Barcode</th>
                            <th>SKU</th>
                            <th>Unit</th>
                            <th>Rate</th>
                            <th>Physical QTY</th>
                            <th>Adjust QTY</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in stockDetails" :key="item.id"   style="border-top: 1px solid rgb(219, 217, 217);">
                            <td>{{ item.product_id.name }}</td>
                            <td>{{ item.product_id.barcode }}</td>
                            <td>{{ item.product_id.sku }}</td>
                            <td>{{ item.product_id.packing_unit.unit }}</td>
                            <td>{{ item.product_id.selling_price }}</td>
                            <td>{{ item.product_id.quantity }}</td>
                            <td>{{ item.adjust_qty }}</td>
                            <td>{{ item.value }}</td>
                        </tr>
                        <tr style="border-top: 1px solid rgb(219, 217, 217);">
                            <td colspan="6"></td>
                            <td style="font-weight: bold;">Total:</td>
                            <td style="font-weight: bold;" v-if="stockAdjustment.length > 0">{{ stockAdjustment[0].total_value }}</td>
                        </tr>
                    </tbody>
                </table>
                <br><br><br><br><br><br>
            </div>
            <table>

            </table>
            <div class="row">
                <div v-if="stockAdjustment.length > 0" class="col-lg-10">
                    <h7 style="font-weight: bold;">Remarks:</h7> <br>
                    <h7>{{ stockAdjustment[0].remarks }}</h7>
                </div>
                <div class="col-lg-10">
                    <h7>Created by:</h7> <br>
                    <h7>{{ userName }}</h7>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
import { format } from 'date-fns';

export default {
    name: 'StockAdjustmentDetail',
    data() {
        return {
            stockDetails: '',
            stockAdjustment: [],
            userName: '',
            userEmail: '',
            userPhone: '',
        }
    },
    methods: {
        async dataFetch() {
            try{
            const response = await axios.get(`api/stock_adjustment/detail/${this.$route.params.id}`);
            this.stockDetails = response.data.detail;
            this.stockAdjustment = response.data.stockadjustment;

            const formattedDate = format(new Date(this.stockAdjustment[0].date), 'dd-MMM-yyyy');
            this.stockAdjustment[0].date = formattedDate;
        } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
            
        },

        async downloadPDF() {
            const pdfElement = document.getElementById('PDFinvoice');

            // Use html2canvas to capture the content as an image
            const canvas = await html2canvas(pdfElement);

            // Configuration for jsPDF
            const pdfOptions = {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait',
            };

            // Create a new jsPDF instance
            const doc = new jsPDF(pdfOptions);

            // Configure the imageSmoothingEnabled property for the PDF
            doc.context2d.imageSmoothingEnabled = false;

            // Calculate the width and height of the image on the PDF
            const imgWidth = 190;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            // Add the captured image to the PDF
            doc.addImage(canvas, 'PNG', 10, 10, imgWidth, imgHeight);

            // Save the PDF with a specified filename
            doc.save('stock_adjustment.pdf');
        },
    },
    mounted() {
        this.dataFetch()

        const storedUser = localStorage.getItem('user');

        if (storedUser) {
            // Parse the stored user information
            const user = JSON.parse(storedUser);
            this.userName = user.name;
            this.userEmail = user.email;
            this.userPhone = user.phone;
        }
        console.log(storedUser)

    }
}
</script>

<style scoped>
.print {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

td,
th {
    border: none;
}
</style>