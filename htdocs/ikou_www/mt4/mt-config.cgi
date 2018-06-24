##          Movable Type configuration file                   ##
##                                                            ##
## This file defines system-wide settings for Movable Type    ##
## In total, there are over a hundred options, but only those ##
## critical for everyone are listed below.                    ##
##                                                            ##
## Information on all others can be found at:                 ##
## http://www.movabletype.jp/documentation/config

################################################################
##################### REQUIRED SETTINGS ########################
################################################################

# The CGIPath is the URL to your Movable Type directory
CGIPath    http://www.kimuko.net/mt4/

# The StaticWebPath is the URL to your mt-static directory
# Note: Check the installation documentation to find out 
# whether this is required for your environment.  If it is not,
# simply remove it or comment out the line by prepending a "#".
StaticWebPath    http://www.kimuko.net/mt4-static

#================ DATABASE SETTINGS ==================
#   REMOVE all sections below that refer to databases 
#   other than the one you will be using.

##### MYSQL #####
ObjectDriver DBI::mysql
Database mt4
DBUser kimqrstst
DBPassword stQRYZyzyz
DBHost fsv15816101.mysql.db.fsv.jp

PublishCharset EUC-JP
ImageDriver NetPBM
NetPBMPath /usr/local/netpbm/bin 
DBUmask 0022
HTMLUmask 0022
UploadUmask 0022
DirUmask 0022

AltTemplate feed results_feed.tmpl